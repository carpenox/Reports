# Vicidial (asterisk) Database - Searchable database, its tables and fields thats used for ViciDIal


# Reports
Custom Reports for Vicidial

## install instructions - clone the github to /var/www/html/vicidial/Reports for Alma/Rocky/centOS or /srv/www/htdocs/vicidial/Reports/ for OpenSuSe

```
cd /var/www/html/vicidial/
cd /srv/www/htdocs/
mkdir Reports
cd Reports
git clone https://github.com/carpenox/Reports.git
```


### did_report.php - Custom report to get a call count per area code and how many DID's you should have per area code based on a 6 day work week with 50 calls or less on each per day(new spam risk math for 2025) - also able to export that data to CSV file

### dids_per_campaign.php -This report connects to the MySQL database, retrieves call data based on the date range filter, and generates a report showing calls per area code grouped by campaign ID. It also calculates the number of DIDs needed to keep the call count below 50 calls per day for the selected date range and provides an option to download the report as a CSV file.


### call_count_campaign.php - This report connects to the MySQL database, retrieves call data based on the date range filter, and generates a report showing calls per area code grouped by campaign ID. It also provides an option to download the report as a CSV file.

### sales.php - Will show the sales and what list they are from for a chosen date range

### humans.php - this report with give you the Outbound CID,	Total Calls,	Human Answered Calls, and	Human Answer Rate (%) for your DID's on a chosen date range
