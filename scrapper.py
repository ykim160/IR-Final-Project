#!/usr/bin/env python3

'''
        This is a scrapper that scraps Imgur by its various categories.
        In order to run the scrapper, you need an API token that is provided
        by Imgur.
	
'''

from imgurpython import ImgurClient
from helpers import get_input, get_config
from nltk.stem import PorterStemmer
from collections import defaultdict

import re
from bs4 import BeautifulSoup
from urllib.request import urlopen

image_src_indicator_0 = "https://i.imgur.com"
image_src_indicator_1 = "http://i.imgur.com"

P_STEMMER = PorterStemmer()

CATAGORY = ["dog", "science_and_tech", "current_events", \
            "gaming", "awesome", "inspiring", "creativity", \
            "aww", "reaction", "funny"]

CATAGORY_STEMMED = [P_STEMMER.stem(catagory) for catagory in CATAGORY]


def authenticate():
    # Get client ID and secret from auth.ini
    config = get_config()
    config.read('auth.ini')
    client_id = config.get('credentials', 'client_id')
    client_secret = config.get('credentials', 'client_secret')

    client = ImgurClient(client_id, client_secret)

    # Authorization flow, pin example (see docs for other auth types)
    authorization_url = client.get_auth_url('pin')

    print("Go to the following URL: {0}".format(authorization_url))

    # Read in the pin, handle Python 2 or 3 here.
    pin = get_input("Enter pin code: ")

    # ... redirect user to `authorization_url`, obtain pin (or code or token) ...
    credentials = client.authorize(pin, 'pin')
    client.set_user_auth(credentials['access_token'], credentials['refresh_token'])

    print("Authentication successful! Here are the details:")
    print("   Access token:  {0}".format(credentials['access_token']))
    print("   Refresh token: {0}".format(credentials['refresh_token']))

    return client


def retrieve_features(url, tag_str):
    feature = []
    for tag in url.tags:
        #print tag
        try:
            if tag[u'description_annotations']:
                for i in tag[u'description_annotations'].keys():
                    feature.append(str(tag[u'description_annotations'][i]).lower())
        except KeyError:
            pass

        try:
            for w in str(tag[u'description']).split():
                feature.append(w.lower())
        except KeyError:
            pass
        
        try:
            for w in str(tag[u'display_name']).split():
                feature.append(w.lower())
        except KeyError:
            pass
        
        try:
            for w in str(tag[u'name']).split():
                feature.append(w.lower())
        except KeyError:
            pass


    if url.title:
        for w in url.title.split():
            feature.append(w.lower())
    
    if url.section:
        for w in url.section.split():
            feature.append(w.lower())
    
    if url.description:
        for w in url.description.split():
            feature.append(w.lower())

    ret = defaultdict(int)

    for i in feature:
        nw = ("".join(re.findall("[a-zA-Z0-9]", i))).encode('utf-8').lower()
        if nw:
            ret[P_STEMMER.stem(nw)] += 1
    
    tpls = sorted(ret.items(), key=lambda x: x[1])

    secondary_feat = ""

    for w, c in tpls:
        if w in CATAGORY_STEMMED:
            if w != CATAGORY_STEMMED[CATAGORY.index(tag_str)]:
                secondary_feat = CATAGORY[CATAGORY_STEMMED.index(w)]

    # ret_str = str(url.title).encode('utf-8') + ", " + tag + ", " + secondary_feat
    url.title.encode('utf-8')
    # str(url.title.encode('utf-8')).encode('utf-8')
    ret_lst = [url.title.encode('utf-8').decode('utf-8').replace("\n", " ").replace(",", ".."),\
               tag_str, secondary_feat]

    return ret_lst
    

def scrap_frontpage(client, tag):
    site_feature = {}
    links = client.gallery_tag(tag)

    for url in links.items:
        features = retrieve_features(url, tag)
        site_feature[retrieve_image_src(str(url.link))] = features

    return site_feature


def get_src_link(root, html):
    soup = BeautifulSoup(html, 'html.parser')
    # for link in soup.find_all('link'):
    for link in soup.find_all('link'):
        if 'rel="image_src"' in str(link):
            link_split = str(link).split('"')
            for elem in link_split:
                if image_src_indicator_0 in elem:
                    return elem
                elif image_src_indicator_1 in elem:
                    return elem
        
    return None

# https://api.imgur.com/oauth2/authorize?client_id=c472f80cd8c260b&response_type=pin
def retrieve_image_src(l):
    if image_src_indicator_0 in str(l):
        return str(l)
    elif image_src_indicator_1 in str(l):
        return str(l)
    else:
        r = urlopen(str(l))
        return get_src_link(str(l), r.read())

    return None


def make_csv_file(filename, links):
    my_csv_file = open(filename, 'w')  
    for url in links.keys():
        my_csv_file.write(url + ", ")
        my_csv_file.write(links[url][0].encode('utf-8'))
        my_csv_file.write(", " + links[url][1])
        my_csv_file.write(", " + links[url][2])
        my_csv_file.write("\n")
    
    my_csv_file.close()


if __name__ == "__main__":
    client = authenticate()
    for tag in CATAGORY:
        print ("MAKING CSV FOR", tag.upper(), "TAG")
        links = scrap_frontpage(client, tag)
        make_csv_file(tag + ".csv", links)

