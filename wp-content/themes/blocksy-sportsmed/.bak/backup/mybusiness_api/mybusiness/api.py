
from google.oauth2 import service_account
from googleapiclient.discovery import build

credentials = service_account.Credentials.from_service_account_file('/Users/alexnewman/Local Sites/spineandsportsmed/app/public/wp-content/themes/blocksy-sportsmed/inc/mybusiness_api/client_secret.json')
service = build('mybusinessbusinessinformation', 'v1', credentials=credentials)

def get_accounts():
    return service.accounts().list().execute()

def get_locations(account_name):
    return service.accounts().locations().list(parent=account_name).execute()

