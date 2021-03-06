<?php
namespace App\Core;

/**
    * Class Functions with public accessible functions
    */
class Functions
{

    public function __construct() {
        @set_exception_handler(array($this, 'eMessage'));
    }

    /*
    * eMessage: global error handler
    */
    public function eMessage($e) {
    //error message
        echo "<br> YourSiteName Error Message :<br>";
        echo "<br> ERROR :: File : " . $e->getFile();
        echo "<br> ERROR :: line : " . $e->getLine();
        echo "<br> ERROR :: Message : ". $e->getMessage();
    }


    /*
    * Path checking at View base level - View.php
    * @params   int     $renderOption 0,1,2
    * @params   array   $paths
    */
    public static function checkPath ( $renderOption, $paths = array() )
    {
        if (empty( $renderOption ) )
            throw new \Exception("Functions.php : checkPath : renderOption required !");
        foreach( $paths[$renderOption] as $path)
            if ( !is_readable( $path ) )
                throw new \Exception("Functions.php : checkPath : File doesn't exist : $path");
            else
                return true;
    } //END checkPath


    /*
    * rendering the page - View.php
    * @params   int    $renderOption 0,1,2
    * @params   array   $paths
    * @params   array   $data
    */
    public static function renderPage($renderOption, $paths = array(), $data = array() )
    {
        if ( self::checkPath ( $renderOption, $paths) )
        {
            extract( $data );
            foreach( $paths[$renderOption] as $path) {
                if (is_readable( $path ) ) {
                    require $path;
                } else {
                    throw new \Exception("Functions.php : renderPage : NO such document exits : $path");
                }

            }
        }
        else
            throw new \Exception("Functions.php : renderPage : the checkPath : FAILED");
    } //END renderPage


    public static function is_validEmail($email)
    {
        $check = 0;
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $check = 1;
        }
        return $check;
    }



} //END CLASS
