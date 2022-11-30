<?php
namespace App\Controller;

use App\Controller\AppController;
use \Google_Client;
use \Google_Service_Sheets;
use \Google_Service_Sheets_ValueRange;

/**
 * GoogleSheets Controller
 *
 *
 * @method \App\Model\Entity\GoogleSheet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GoogleSheetsController extends AppController
{
    /**
     * $MY_KEY attribute : the api key of GoogleCalendar
     */
    public $CREDENTIALS;
    public $TOKENPATH;

    function __construct() {
        parent::__construct();
        $this->CREDENTIALS = __DIR__.'/json/credentialsSheet.json';
        $this->TOKENPATH = __DIR__.'/json/tokenSheet.json';

        // $this->CREDENTIALS = '';
        // $this->TOKENPATH = '';
    }

    public function initialize()
    {
        parent::initialize();
		$this->loadModel("Annonces");
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    function getClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig($this->CREDENTIALS);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = $this->TOKENPATH;
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    /**
     * googleSheetGet method
     */
    public function googleSheetGet()
    {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new Google_Service_Sheets($client);

        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1vxD6nsty9u2hGm00Ub6PJOOaXleJImMyAs09ZgD7BvA';
        $range = 'A2';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            print "No data found.\n";
        } else {
            foreach ($values as $row) {
                // Print columns A and E, which correspond to indices 0 and 4.
                printf($row[0]);
            }
        }
    }
    /**
     * googleSheetInsertRow method
     */
    public function googleSheetInsertRow($row, $num_ligne)
    {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new Google_Service_Sheets($client);

        // The ID of the spreadsheet to update.
        $spreadsheetId = '1vxD6nsty9u2hGm00Ub6PJOOaXleJImMyAs09ZgD7BvA';  // Alpissime.
        // $spreadsheetId = '1PUDf_ssF2J3vlqxMQtaknHuie156cVJvNWU723XFNQg';  // Sheet de test.
        // $spreadsheetId = '15ZqOc5FnEZRO0HY0qR8DAqeL5NyXS6WiKVDvtWAXi6I';  // Sheet de test2.
        

        // The A1 notation of the values to update.
        $range = 'A'.$num_ligne;  // TODO: Update placeholder value.

        // TODO: Assign values to desired properties of `requestBody`. All existing
        // properties will be replaced:
        $requestBody = new Google_Service_Sheets_ValueRange([
            'majorDimension' => 'ROWS',
            'range' => $range,
            'values' => [$row]
        ]);

        $response = $service->spreadsheets_values->update($spreadsheetId, $range, $requestBody, array('valueInputOption' => USER_ENTERED));

        // TODO: Change code below to process the `response` object:
        echo '<pre>', var_export($response, true), '</pre>', "\n";

    }

}
