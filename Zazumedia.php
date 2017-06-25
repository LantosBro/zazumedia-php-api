<?php

/*
 * ZazuMedia API
 *
 * @version v0.0.1
 * @docs http://docs.zazumedia.ru/
 */

class Zazumedia
{
    private $url = 'https://api.zazumedia.ru';
    private $file_token_path = '';
    private $token;
    private $login;
    private $response;

    public function __construct( $login, $file_path = false ) {
        if ( ! $login ) {
            throw new Exception( 'Login not available' );
        }
        $this->login = $login;

        if ( $file_path ) {
            $this->file_token_path = $file_path;
        } else {
            $this->file_token_path = $login;
        }

        if ( file_exists( $this->file_token_path ) ) {
            $this->token = file_get_contents( $this->file_token_path );
        }

        if ( ! $this->token ) {
            throw new Exception( 'token not available' );
        }
    }

    /**
     * Get account info
     *
     * @return stdClass
     */
    public function getInfo() {

        return $this->request( 'info' );
    }

    /**
     * Send sms message
     *
     * @param $type
     * @param $phone
     * @param $message
     * @param $sender
     * @return stdClass
     */
    public function sendSms( $type, $phone, $message, $sender = false ) {

        return $this->request( 'sms/send', compact(
            'type',
            'phone',
            'message',
            'sender'
        ) );
    }

    /**
     * Check status sms message
     *
     * @param $id
     * @return stdClass
     */
    public function checkSmsStatus( $id ) {

        return $this->request( 'sms/status', compact(
            'id'
        ) );
    }

    /**
     * Send viber message
     *
     * @param $type
     * @param $phone
     * @param $message
     * @param $sender
     * @param $btntext
     * @param $btnlink
     * @param $picpath
     * @return stdClass
     */
    public function sendViber( $type, $phone, $message, $sender= false, $btntext = false, $btnlink = false, $picpath = false ) {

        return $this->request( 'viber/send', compact(
            'type',
            'phone',
            'message',
            'sender',
            'btntext',
            'btnlink',
            'picpath'
        ) );
    }

    /**
     * Check status viber message
     *
     * @param $id
     * @return stdClass
     */
    public function checkViberStatus( $id ) {

        return $this->request( 'viber/status', compact(
            'id'
        ) );
    }

    /**
     * Request zazumedia with params
     *
     * @param $path
     * @param $params
     * @return stdClass
     */
    private function request( $path, $params = [] ) {
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $this->url . '/' . $path );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token
        ] );
        curl_setopt( $curl, CURLOPT_POST, count( $params ) );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $params ) );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_HEADER, 1 );

        $response = curl_exec( $curl );
        $header_size = curl_getinfo( $curl, CURLINFO_HEADER_SIZE );
        $http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
        $body = substr( $response, $header_size );
        $headers = substr( $response, 0, $header_size );

        $this->refreshToken( $headers );

        curl_close( $curl );

        $this->response = new stdClass();
        $this->response->result = true;
        $this->response->data = json_decode( $body );
        $this->response->http_code = $http_code;

        if ( $http_code != 200 ) {
            $this->response->result = false;
        }
        if ( $http_code == 401 && $this->response->data->error == 'token_expired' ) {
            return $this->request( $path, $params );
        }

        return $this->response;
    }

    /**
     * Refresh auth token from headers
     *
     * @param $headers
     */
    private function refreshToken( $headers ) {
        $token = null;
        $headers = explode( "\r\n", $headers );
        foreach ( $headers as $header ) {
            if ( strstr( $header, "Authorization: Bearer " ) ) {
                $token = str_replace( "Authorization: Bearer ", "", $header );
            }
        }
        if ( $token ) {
            $this->token = $token;
            $file_token = fopen( $this->file_token_path, "w" );
            fwrite( $file_token, $this->token );
            fclose( $file_token );
        }
    }
}