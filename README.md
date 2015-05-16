# Google Cloud Storage PHP Sample Application

## Description
This is a new version of the old Google Cloud Storage PHP Sample App from 2013. It primarily focuses on starting/stopping/displaying instances from Google Developer's Console. It's goal is to set up pre-configured instances with a click of a button. Keys and IDs must be added if you wish to use.


## Setup Authentication
NOTE: This README assumes that you have enabled access to the Google Cloud
Engine API via the Google API Console page.

1) Visit https://console.developers.google.com to register your
application and generate an API key.
- Click  **APIs & Auth** in the left column, and then click **Credentials**.
- Click **Create new client ID** to create a new client ID.
- In the **Create Client ID** window, choose **Web application**.
- In the **Redirect URIs** box, specify the URL for your PHP page, e.g., http://localhost/app.php.
- Click **Create Client ID**.
- In the **Public API access** section of the **Credentials** page, click **Create new Key**.
- In the **Create a new Key** window, choose **Browser key**.

2) Update app.php with the redirect uri, consumer key, secret, and developer
key obtained in step 1.
- Update `YOUR_CLIENT_ID` with your oauth2 client id.
- Update `YOUR_CLIENT_SECRET` with your oauth2 client secret.
- Update `YOUR_REDIRECT_URI` with the fully qualified redirect URI, e.g., http://localhost/app.php.
- Update `YOUR_API_KEY` with your API key.
- Update `YOUR_PROJECT_DEFAULT_ID` with your project ID, which
can be found by visiting https://console.developers.google.com and selecting a project.

3) Update app.php with remaining default settings. Search and replace all
strings starting with 'YOUR_DEFAULT_' with their associated values.

## Running the Sample Application
4) Load app.php on your web server, and visit the appropriate website in
your web browser.

