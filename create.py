import csv


def sql_maker(name, data):
    sql_name = name+".sql"
    table_name = name.capitalize()
    f_name = open(sql_name, "w")
    f_name.write("DROP TABLE IF EXISTS "+table_name+";\n")
    f_name.write("CREATE TABLE "+table_name+"(\n"
                  " Url  VARCHAR(40) primary key,\n"
                  " Title    VARCHAR(200),\n"
                  " One VARCHAR(30),\n"
                  " Two   VARCHAR(30));\n\n")

    for i in data:
        i[0] = i[0].strip()
        i[1] = i[1].strip()
        i[2] = i[2].strip()
        i[3] = i[3].strip()

        quote_index = []
        count = 0
        for c in range(len(i[1])):
            if i[1][c] == "'":
                c += count
                quote_index.append(c)
                count += 1
        for ind in quote_index:
            i[1] = i[1][:ind] + "'" + i[1][ind:]

        if i[3] == "":
            f_name.write("INSERT INTO " + table_name + " VALUES('"+i[0] + "', '" + i[1] + "', '" + i[2]+"', 'None');\n")
        else:
            f_name.write("INSERT INTO "+table_name+" VALUES('"+i[0]+"', '"+i[1]+"', '"+i[2]+"', '"+i[3]+"');\n")


with open("awesome.csv") as f:
    reader = csv.reader(f)
    data = [r for r in reader]

with open("aww.csv") as f:
    reader = csv.reader(f)
    data1 = [r for r in reader]

with open("creativity.csv") as f:
    reader = csv.reader(f)
    data2 = [r for r in reader]

with open("current_events.csv") as f:
    reader = csv.reader(f)
    data3= [r for r in reader]

with open("dog.csv") as f:
    reader = csv.reader(f)
    data4 = [r for r in reader]

with open("funny.csv") as f:
    reader = csv.reader(f)
    data5 = [r for r in reader]

with open("gaming.csv") as f:
    reader = csv.reader(f)
    data6 = [r for r in reader]

with open("inspiring.csv") as f:
    reader = csv.reader(f)
    data7 = [r for r in reader]

with open("reaction.csv") as f:
    reader = csv.reader(f)
    data8 = [r for r in reader]

with open("science_and_tech.csv") as f:
    reader = csv.reader(f)
    data9 = [r for r in reader]

sql_maker("awesome", data)
sql_maker("aww", data1)
sql_maker("creativity", data2)
sql_maker("current_events", data3)
sql_maker("dog", data4)
sql_maker("funny", data5)
sql_maker("gaming", data6)
sql_maker("inspiring", data7)
sql_maker("reaction", data8)
sql_maker("science_and_tech", data9)



