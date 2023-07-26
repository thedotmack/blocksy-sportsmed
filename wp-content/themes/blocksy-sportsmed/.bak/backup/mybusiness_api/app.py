
from flask import Flask, jsonify
from mybusiness import api, auth

app = Flask(__name__)
app.secret_key = 'Vww/w#az3;XsWdk'
auth.init_oauth(app)

@app.route('/getAccounts', methods=['GET'])
def get_accounts():
    accounts = api.get_accounts()
    return jsonify(accounts)

@app.route('/getLocations/<account_name>', methods=['GET'])
def get_locations(account_name):
    locations = api.get_locations(account_name)
    return jsonify(locations)

if __name__ == '__main__':
    app.run(debug=True)

