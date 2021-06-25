<?php

namespace App\Models\Common;

class Values {

    static $cssVersion = "?ver=1.19";
    static $nullStringForTableClass = "saijo566396emptystring000";
    static $nullStringForFormClass = "saijo566396emptystring000";
    static $resCode_success = 200;
    static $resCode_registrationFailure = 101;
    static $resCode_mobileNotRegistered = 102;
    static $resCode_smsError = 103;
    static $resCode_alreadySubScriber = 104;
    static $resCode_CODLimitError = 105;
    static $resCode_loginFailure = 400;
    static $resCode_notAuthenticated = 401;
    static $resCode_notFound = 404;
    static $resCode_otherThanPost = 405;
    static $resCode_validationError = 417;
    static $resCode_internalError = 500;
    static $resCode_userExists = 106;
    static $resMsg_success = "";
    static $resMsg_registrationFailure = "Mobile already registered";
    static $resMsg_mobileNotRegistered = "Not a registered mobile";
    static $resMsg_smsError = "Error occured while sending sms";
    static $resMsg_alreadySubScriber = "You are already a subscriber";
    static $resMsg_loginFailure = "Invalid username or password";
    static $resMsg_notAuthenticated = "You are not authorized";
    static $resMsg_notFound = "Resource not found";
    static $resMsg_otherThanPost = "Method not allowed";
    static $resMsg_validationError = "Invalid data";
    static $resMsg_internalError = "Sorry, its our fault. Contact admin";
    static $resMsg_userExists = "User already registered";

}
