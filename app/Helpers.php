<?php

function ProcessingDocLevelCode($input)
{

    if ($input == "FullDocumentation") {
        return "1";
    } else if ($input == "LimitedDocumentation") {
        return "3";
    } else if ($input == "NoRatio") {
        return "5";
    } else if (
        $input == "NoIncomeNoEmploymentNoAssetsOn1003" ||
        $input == "NoEmploymentVerificationOrIncomeVerification" ||
        $input == "NoIncomeOn1003"
    ) {
        return "6";
    } else if ($input == "NoDepositVerification") {
        return "7";
    } else if ($input == "Reduced") {
        return "8";
    } else if (stristr($input, "NoVerificationOfStated")) {
        return "9";
    } else if ($input == "NoDepositVerificationEmploymentVerificationOrIncomeVerification") {
        return "0";
    } else {
        return $input;
    }
}

function ProcessingPropertyTypeCode($input_1, $input_2)
{

    if ($input_2 <= 1) {

        if ($input_1 == "Condominium" || $input_1 == "DetachedCondo" || $input_1 == "HighRiseCondominium") {
            return "COND";
        } else if ($input_1 == "Cooperative") {
            return "COOP";
        } else if ($input_1 == "ManufacturedHousing") {
            return "MFH";
        } else if ($input_1 == "PUD") {
            return "PUD";
        } else if ($input_1 ==  "Attached") {
            return "TOWN";
        } else if ($input_1 ==  "Detached") {
            return "SFR";
        } else {
            return $input_1;
        }
    } else if ($input_2 == 2) {
        return "2F";
    } else if ($input_2 == 3) {
        return "3F";
    } else if ($input_2 == 4) {
        return "4F";
    } else if ($input_2 == 5) {
        return "5+F";
    } else {
        return $input_1;
    }
}

function ProcessingPurposeCode($input)
{

    if ($input == "ConstructionToPermanent") {
        return "CP";
    } elseif ($input == "Purchase") {
        return "P";
    } elseif ($input == "Cash-Out Refinance") {
        return "CO";
    } elseif ($input == "NoCash-Out Refinance") {
        return "R";
    } else {
        return "";
    }
}

function ProcessingOccupancyCode($input)
{

    if ($input == "PrimaryResidence") {
        return "O";
    } elseif ($input == "SecondHome") {
        return "S";
    } else {
        return "I";
    }
}


function ProcessingCitizenshipFlag($input)
{

    if ($input == "USCitizen") {
        return "0";
    } else {
        return "1";
    }
}


function ProcessingChannel($input)
{

    if ($input == "Retaiil") {
        return "RETL";
    } elseif ($input == "Broker") {
        return "WHSL";
    } else {
        return "CORR";
    }
}

function DateConversion($input)
{

    if (strlen($input) < 10) {
        return "";
    } else {
        return $input;
    }
}
