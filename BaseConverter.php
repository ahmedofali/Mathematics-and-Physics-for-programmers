<?php

define( 'Binary', 'Binary' );
define( 'Decimal', 'decimal' );
define( 'HexaDecimal', 'hexadecimal' );

function ConvertBase( $number, $base1, $base2 )
{
    switch( $base1 )
    {
        case Binary :
            switch ( $base2 )
            {
                case Decimal:
                    return fromBinaryToDecimal( $number );

                case HexaDecimal:
                    return fromBinaryToHexaDecimal( $number );
            }

        case Decimal:
            switch ( $base2 )
            {
                case Binary:
                    return fromDecimalToBinary($number);

                case HexaDecimal:
                    return fromDecimalToHexaDecimal($number);
            }

        case HexaDecimal:
            switch ( $base2 )
            {
                case Binary:
                    return fromDecimalToBinary( $number );

                case Decimal:
                    return fromDecimalToHexaDecimal( $number );
            }
    }
}

/**
 * Convert From Base 2 to Base 10
 *
 * @param String $number
 * @return float|int
 */
function fromBinaryToDecimal( String $number )
{
    $numbers = str_split( $number );

    $numbers_size = sizeof( $numbers ) - 1;

    $sum = 0 ;

    foreach( $numbers as $key => $number )
    {
        $sum += $number * ( 2 ** ( $numbers_size - $key ) ) ;
    }

    return $sum ;
}

/**
 * Convert From Decimal to Binary
 *
 * @param String $number
 * @return string
 */
function fromDecimalToBinary( String $number )
{
    return get_reminders( ( int ) $number );
}

/**
 * Convert from Binary to Hexadecimal
 *
 * @param String $number
 * @return string
 */
function fromBinaryToHexaDecimal( String $number )
{
    $array = array_reverse( str_split( $number ) );

    $chunks = array_chunk( $array, 4);

    $result = '' ;

    foreach( $chunks as $key => $chunk )
    {
        $decimal_result = fromBinaryToDecimal( strrev( implode( '', $chunk ) ) );

        $result = convertNumToHexaDecimalAndViceVersa( ( int ) $decimal_result ) . $result ;
    }

    return $result ;
}

/**
 * Convert Hexadecimal to Binary
 *
 * @param String $number
 * @return string
 */
function fromHexaDecimalToBinary( String $number )
{
    $decimal = fromBinaryToDecimal( $number );

    return fromDecimalToHexaDecimal( $decimal );
}


/**
 * Convert From Decimal to Hexadecimal
 * @param String $number
 * @return string
 */
function fromDecimalToHexaDecimal( String $number )
{
    return get_reminders( ( int ) $number, 16 );
}

/**
 * Convert from Hexadecimal to decimal
 *
 * @param String $number
 * @return float|int
 */
function fromHexaDecimalToDecimal( String $number )
{
    $numbers = str_split( $number );

    $numbers_size = sizeof( $numbers ) - 1;

    $sum = 0 ;

    foreach( $numbers as $key => $number )
    {
        $sum += convertNumToHexaDecimalAndViceVersa( $number ) * ( 16 ** ( $numbers_size - $key ) ) ;
    }

    return $sum ;
}

///////////////////////////////////////////////////////////////////////////////////
/// Helper Functions
///////////////////////////////////////////////////////////////////////////////////
/**
 * Convert Num To Hexadecimal and vice versa
 *
 * @param $number
 * @return int|string
 */
function convertNumToHexaDecimalAndViceVersa( $number )
{
    switch( $number )
    {
        case 10 :
            return 'A';

        case 11 :
            return 'B';

        case 12 :
            return 'C';

        case 13 :
            return 'D';

        case 14 :
            return 'E';

        case 15 :
            return 'F';

        case 'A' :
            return 10;

        case 'B' :
            return 11;

        case 'C' :
            return 12;

        case 'D' :
            return 13;

        case 'E' :
            return 14;

        case 'F' :
            return 15;

        default :
            return $number ;
    }
}

/**
 * Get Number Remainders ex: 7 = '111'
 *
 * @param $number
 * @param int $base
 * @return string
 */
function get_reminders( $number, $base = 2 )
{
    $result = '' ;

    if( $number <= 0 )
    {
        return $result ;
    }

    $result .= get_reminder( $number, $base );

    $division_result = ( int ) ( $number / $base ) ;

    $reminder = get_reminders( $division_result, $base );

    if( $base == 16 ) { $reminder = convertNumToHexaDecimalAndViceVersa( $reminder ) ; }

    $result = $reminder . $result;

    return $result ;
}

/**
 * Get Number Remainder
 *
 * @param int $number
 * @param int $base
 * @return float|int
 */
function get_reminder( int $number, $base = 2 )
{
    $division_result = $number / $base ;

    $int_division_result = ( int ) $division_result ;

    $fraction = $division_result - $int_division_result ;

    $remainder = $fraction * $base ;

    return $remainder ;
}