# Vicidial (asterisk) Database - Searchable database, its tables and fields thats used for ViciDIal


# Reports
Custom Reports for Vicidial

## install instructions - clone the github to /var/www/html/vicidial/Reports for Alma/Rocky/centOS or /srv/www/htdocs/vicidial/Reports/ for OpenSuSe

```
cd /var/www/html/vicidial/
cd /srv/www/htdocs/vicidial/
git clone https://github.com/carpenox/Reports.git
cp dbconnect_mysqli.php functions.php Reports
```

## You will then be able to find the reports at https://yourdomain/vicidial/Reports/

### did_report.php - Custom report to get a call count per area code and how many DID's you should have per area code based on a 6 day work week with 50 calls or less on each per day(new spam risk math for 2025) - also able to export that data to CSV file

![Screenshot 2025-01-11 162201](https://github.com/user-attachments/assets/59b5d507-9e3d-427d-8b84-b04dc0d6e198)

### dids_per_campaign.php -This report connects to the MySQL database, retrieves call data based on the date range filter, and generates a report showing calls per area code grouped by campaign ID. It also calculates the number of DIDs needed to keep the call count below 50 calls per day for the selected date range and provides an option to download the report as a CSV file.


![Screenshot 2025-01-13 164627](https://github.com/user-attachments/assets/f27e23f8-f6c2-4162-b203-3c31bd000c41)

### call_count_campaign.php - This report connects to the MySQL database, retrieves call data based on the date range filter, and generates a report showing calls per area code grouped by campaign ID. It also provides an option to download the report as a CSV file.

![Screenshot 2025-01-13 164627](https://github.com/user-attachments/assets/e65a71a9-95b8-4929-a951-1cbc9cbc650a)


### sales.php - Will show the sales and what list they are from for a chosen date range

![Screenshot 2025-02-19 101753](https://github.com/user-attachments/assets/759833c3-2333-4b2c-a1c1-1c5c1142e5ce)


### humans.php - this report with give you the Outbound CID,	Total Calls,	Human Answered Calls, and	Human Answer Rate (%) for your DID's on a chosen date range

![Screenshot 2025-02-13 041234](https://github.com/user-attachments/assets/e1a8ec82-00c1-4c7b-9569-4daca039b0fc)
![Screenshot 2025-02-13 041254](https://github.com/user-attachments/assets/3bb862af-41b3-42ca-9578-fc48bf4d1b8a)



### users-upload.php - a tool to upload a csv file in the format like the example file users.csv which will create all the users, phone and phonealias in the vicidial database, must make sure the user_id is not being used already in the system. Even if the user may be user "1000" the user_id may be "3".

![Screenshot 2025-02-25 225533](https://github.com/user-attachments/assets/ef48c110-b4dc-4f56-a813-229e625ba1a2)

![image](https://github.com/user-attachments/assets/427d8cc8-aa7f-4e44-886e-5809cec9230b)


![image](https://github.com/user-attachments/assets/2770cf52-1d52-497c-9f90-d5b4dfd43030)

### record-search.html  - A tool to search records/leads by user and status (backend parts include fetch_users.php, fetch_statuses.php and generate_report.php

![image](https://github.com/user-attachments/assets/2d241f1e-7539-4097-b12c-eacf21c55f8b)




