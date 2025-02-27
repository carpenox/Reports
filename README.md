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


### did_report.php - Custom report to get a call count per area code and how many DID's you should have per area code based on a 6 day work week with 50 calls or less on each per day(new spam risk math for 2025) - also able to export that data to CSV file

### dids_per_campaign.php -This report connects to the MySQL database, retrieves call data based on the date range filter, and generates a report showing calls per area code grouped by campaign ID. It also calculates the number of DIDs needed to keep the call count below 50 calls per day for the selected date range and provides an option to download the report as a CSV file.


### call_count_campaign.php - This report connects to the MySQL database, retrieves call data based on the date range filter, and generates a report showing calls per area code grouped by campaign ID. It also provides an option to download the report as a CSV file.

### sales.php - Will show the sales and what list they are from for a chosen date range

### humans.php - this report with give you the Outbound CID,	Total Calls,	Human Answered Calls, and	Human Answer Rate (%) for your DID's on a chosen date range

### users-upload.php - a tool to upload a csv file in the format like the example file users.csv which will create all the users, phone and phonealias in the vicidial database, must make sure the user_id is not being used already in the system. Even if the user may be user "1000" the user_id may be "3".

![Screenshot 2025-02-25 225533](https://github.com/user-attachments/assets/ef48c110-b4dc-4f56-a813-229e625ba1a2)

![image](https://github.com/user-attachments/assets/427d8cc8-aa7f-4e44-886e-5809cec9230b)


![image](https://github.com/user-attachments/assets/2770cf52-1d52-497c-9f90-d5b4dfd43030)



