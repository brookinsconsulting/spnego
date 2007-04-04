<?php

class eZSPNEGOSSOHandler
{
    function eZSPNEGOSSOHandler()
    {
    }

    /*!
     \todo add an INI option to specify that an authenticated user should be created automatically in the eZ publish database
     \todo if basic auth is used, we should tell the user how to set up Negotiate authentication with Firefox
           maybe set some global variable with messages which can be checked in the pagelayout, and give the user the possibility
           to disable displaying the message with a user preference
    */
    function handleSSOLogin()
    {
        include_once( 'lib/ezutils/classes/ezdebugsetting.php' );

        if ( array_key_exists( 'REMOTE_USER', $_SERVER ) && array_key_exists( 'AUTH_TYPE', $_SERVER ) )
        {
            $remoteUser = $_SERVER['REMOTE_USER'];
            $authType = $_SERVER['AUTH_TYPE'];

            eZDebugSetting::writeDebug( 'kernel-user', 'remote user: ' . $remoteUser, 'authentication type: ' . $authType, 'eZSPNEGOSSOHandler' );

            $loginParts = explode( '@', $remoteUser );
            $loginName = $loginParts[0];

            $user = eZUser::fetchByName( $loginName );
            // if not found eZUser::fetchByName returns NULL, but the return value of this function will be checked with !== false in eZUser::instance
            if ( is_object( $user ) )
            {
                return $user;
            }
            else
            {
                eZDebugSetting::writeDebug( 'kernel-user', 'unable to fetch remote user from local database', 'eZSPNEGOSSOHandler' );
            }
        }
        else
        {
            eZDebugSetting::writeDebug( 'kernel-user', 'no sso authentication performed', 'eZSPNEGOSSOHandler' );
        }

        return false;
    }
}

?>