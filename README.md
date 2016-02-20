# trialbigdata
Trial task for bigdata

There is a data file
/test_data.csv
It's about people data
Data from different sources, shot down in one "heap" (3 blocks in a file - 1000, 1000 and 100 lines)
The number of lines can vary (tens of millions of rows) in each block, but the number and structure of each block is not changed

A task:
Design a database (mysql)
Write a script on of PHP5, which "disassemble" the data, create and populate the database. We collect the following information: name, phone, email, address, company, title, interests, CardNumber, date of birth, a website, a sex.

The result should be SQL query to retrieve data of several people who (supposedly) are physically one and the same person. A sign of "identity" may be an email, phone, card number (perhaps something more, to your decision).

According to legend, is the database for the tens of millions of "people", therefore, must be designed correctly.
