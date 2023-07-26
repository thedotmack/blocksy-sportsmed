
from authlib.integrations.flask_client import OAuth
from flask import session, url_for, redirect

def init_oauth(app):
    oauth = OAuth(app)

    oauth.register(
        name='google',
        client_id='922689013256-cp8n7pv5vh22j7gpkml75da7bj12osea.apps.googleusercontent.com',
        client_secret='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',
        access_token_url='https://accounts.google.com/o/oauth2/token',
        access_token_params=None,
        authorize_url='https://accounts.google.com/o/oauth2/auth',
        authorize_params=None,
        api_base_url='https://www.googleapis.com/oauth2/v1/',
        userinfo_endpoint='https://openidconnect.googleapis.com/v1/userinfo',
        client_kwargs={'scope': 'openid email profile'},
    )

    @app.route('/login')
    def login():
        google = oauth.create_client('google')
        redirect_uri = url_for('authorize', _external=True)
        return google.authorize_redirect(redirect_uri)

    @app.route('/authorize')
    def authorize():
        google = oauth.create_client('google')
        token = google.authorize_access_token()
        resp = google.get('userinfo')
        user_info = resp.json()
        session['email'] = user_info['email']
        return redirect('/')

