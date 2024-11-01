<?php
// Format : currency symbol (ISO4217) (optional: + decimal digits 0 by default) => displayed text 
// The current layout only allow up to 4 characters in the displayed text.
// Examples : JPY => JPY = Japanese yen with 0 decimal, EUR2 => &euro; = Euro with 2 decimals displaying euro symbol

$currency_list = array (
// Full list below (Feel free to change the second part of the items)
// Uncomment to include the currency
// Comment to exclude the currency
//  "AED" => "AED", //United Arab Emirates, Dirhams
//  "AFN" => "AFN", //Afghanistan, Afghanis
//  "ALL" => "ALL", //Albania, Leke
//  "AMD" => "AMD", //Armenia, Drams
//  "ANG" => "ANG", //Netherlands Antilles, Guilders (also called Florins)
//  "AOA" => "AOA", //Angola, Kwanza
//  "ARS" => "ARS", //Argentina, Pesos
//  "AUD" => "AUD", //Australia, Dollars
//  "AWG" => "AWG", //Aruba, Guilders (also called Florins)
//  "AZM" => "AZM", //Azerbaijan, Manats [obsolete]
//  "AZN" => "AZN", //Azerbaijan, New Manats
//  "BAM" => "BAM", //Bosnia and Herzegovina, Convertible Marka
//  "BBD" => "BBD", //Barbados, Dollars
//  "BDT" => "BDT", //Bangladesh, Taka
//  "BGN" => "BGN", //Bulgaria, Leva
//  "BHD" => "BHD", //Bahrain, Dinars
//  "BIF" => "BIF", //Burundi, Francs
//  "BMD" => "BMD", //Bermuda, Dollars
//  "BND" => "BND", //Brunei Darussalam, Dollars
//  "BOB" => "BOB", //Bolivia, Bolivianos
//  "BRL" => "BRL", //Brazil, Brazil Real
//  "BSD" => "BSD", //Bahamas, Dollars
//  "BTN" => "BTN", //Bhutan, Ngultrum
//  "BWP" => "BWP", //Botswana, Pulas
//  "BYR" => "BYR", //Belarus, Rubles
//  "BZD" => "BZD", //Belize, Dollars
//  "CAD" => "CAD", //Canada, Dollars
//  "CDF" => "CDF", //Congo/Kinshasa, Congolese Francs
//  "CHF" => "CHF", //Switzerland, Francs
//  "CLP" => "CLP", //Chile, Pesos
//  "CNY" => "CNY", //China, Yuan Renminbi
//  "COP" => "COP", //Colombia, Pesos
//  "CRC" => "CRC", //Costa Rica, Colones
//  "RSD" => "RSD", //Serbia, Dinars
//  "CUP" => "CUP", //Cuba, Pesos
//  "CVE" => "CVE", //Cape Verde, Escudos
//  "CYP" => "CYP", //Cyprus, Pounds
//  "CZK" => "CZK", //Czech Republic, Koruny
//  "DJF" => "DJF", //Djibouti, Francs
//  "DKK" => "DKK", //Denmark, Kroner
//  "DOP" => "DOP", //Dominican Republic, Pesos
//  "DZD" => "DZD", //Algeria, Algeria Dinars
//  "EEK" => "EEK", //Estonia, Krooni
//  "EGP" => "EGP", //Egypt, Pounds
//  "ERN" => "ERN", //Eritrea, Nakfa
//  "ETB" => "ETB", //Ethiopia, Birr
    "EUR2" => "€", //Euro Member Countries, Euro
//  "FJD" => "FJD", //Fiji, Dollars
//  "FKP" => "FKP", //Falkland Islands (Malvinas), Pounds
    "GBP2" => "£", //United Kingdom, Pounds
//  "GEL" => "GEL", //Georgia, Lari
//  "GGP" => "GGP", //Guernsey, Pounds
//  "GHC" => "GHC", //Ghana, Cedis
//  "GHS" => "GHS", //Ghana, Cedis
//  "GIP" => "GIP", //Gibraltar, Pounds
//  "GMD" => "GMD", //Gambia, Dalasi
//  "GNF" => "GNF", //Guinea, Francs
//  "GTQ" => "GTQ", //Guatemala, Quetzales
//  "GYD" => "GYD", //Guyana, Dollars
//  "HKD" => "HKD", //Hong Kong, Dollars
//  "HNL" => "HNL", //Honduras, Lempiras
//  "HRK" => "HRK", //Croatia, Kuna
//  "HTG" => "HTG", //Haiti, Gourdes
//  "HUF" => "HUF", //Hungary, Forint
//  "IDR" => "IDR", //Indonesia, Rupiahs
//  "ILS" => "ILS", //Israel, New Shekels
//  "IMP" => "IMP", //Isle of Man, Pounds
//  "INR" => "INR", //India, Rupees
//  "IQD" => "IQD", //Iraq, Dinars
//  "IRR" => "IRR", //Iran, Rials
//  "ISK" => "ISK", //Iceland, Kronur
//  "JEP" => "JEP", //Jersey, Pounds
//  "JMD" => "JMD", //Jamaica, Dollars
//  "JOD" => "JOD", //Jordan, Dinars
    "JPY" => "¥", //Japan, Yen
//  "KES" => "KES", //Kenya, Shillings
//  "KGS" => "KGS", //Kyrgyzstan, Soms
//  "KHR" => "KHR", //Cambodia, Riels
//  "KMF" => "KMF", //Comoros, Francs
//  "KPW" => "KPW", //Korea (North), Won
//  "KRW" => "KRW", //Korea (South), Won
//  "KWD" => "KWD", //Kuwait, Dinars
//  "KYD" => "KYD", //Cayman Islands, Dollars
//  "KZT" => "KZT", //Kazakhstan, Tenge
//  "LAK" => "LAK", //Laos, Kips
//  "LBP" => "LBP", //Lebanon, Pounds
//  "LKR" => "LKR", //Sri Lanka, Rupees
//  "LRD" => "LRD", //Liberia, Dollars
//  "LSL" => "LSL", //Lesotho, Maloti
//  "LTL" => "LTL", //Lithuania, Litai
//  "LVL" => "LVL", //Latvia, Lati
//  "LYD" => "LYD", //Libya, Dinars
//  "MAD" => "MAD", //Morocco, Dirhams
//  "MDL" => "MDL", //Moldova, Lei
//  "MGA" => "MGA", //Madagascar, Ariary
//  "MKD" => "MKD", //Macedonia, Denars
//  "MMK" => "MMK", //Myanmar (Burma), Kyats
//  "MNT" => "MNT", //Mongolia, Tugriks
//  "MOP" => "MOP", //Macau, Patacas
//  "MRO" => "MRO", //Mauritania, Ouguiyas
//  "MTL" => "MTL", //Malta, Liri
//  "MUR" => "MUR", //Mauritius, Rupees
//  "MVR" => "MVR", //Maldives (Maldive Islands), Rufiyaa
//  "MWK" => "MWK", //Malawi, Kwachas
//  "MXN" => "MXN", //Mexico, Pesos
//  "MYR" => "MYR", //Malaysia, Ringgits
//  "MZM" => "MZM", //Mozambique, Meticais [obsolete]
//  "MZN" => "MZN", //Mozambique, Meticais [newer unit, same name]
//  "NAD" => "NAD", //Namibia, Dollars
//  "NGN" => "NGN", //Nigeria, Nairas
//  "NIO" => "NIO", //Nicaragua, Cordobas
//  "NOK" => "NOK", //Norway, Krone
//  "NPR" => "NPR", //Nepal, Nepal Rupees
//  "NZD" => "NZD", //New Zealand, Dollars
//  "OMR" => "OMR", //Oman, Rials
//  "PAB" => "PAB", //Panama, Balboa
//  "PEN" => "PEN", //Peru, Nuevos Soles
//  "PGK" => "PGK", //Papua New Guinea, Kina
//  "PHP" => "PHP", //Philippines, Pesos
//  "PKR" => "PKR", //Pakistan, Rupees
//  "PLN" => "PLN", //Poland, Zlotych
//  "PYG" => "PYG", //Paraguay, Guarani
//  "QAR" => "QAR", //Qatar, Rials
//  "ROL" => "ROL", //Romania, Lei [obsolete]
//  "RON" => "RON", //Romania, New Lei
//  "RUB" => "RUB", //Russia, Rubles
//  "RWF" => "RWF", //Rwanda, Rwanda Francs
//  "SAR" => "SAR", //Saudi Arabia, Riyals
//  "SBD" => "SBD", //Solomon Islands, Dollars
//  "SCR" => "SCR", //Seychelles, Rupees
//  "SDD" => "SDD", //Sudan, Dinars [obsolete]
//  "SDG" => "SDG", //Sudan, Pounds
//  "SEK" => "SEK", //Sweden, Kronor
//  "SGD" => "SGD", //Singapore, Dollars
//  "SHP" => "SHP", //Saint Helena, Pounds
//  "SIT" => "SIT", //Slovenia, Tolars [obsolete]
//  "SKK" => "SKK", //Slovakia, Koruny
//  "SLL" => "SLL", //Sierra Leone, Leones
//  "SOS" => "SOS", //Somalia, Shillings
//  "SPL" => "SPL", //Seborga, Luigini
//  "SRD" => "SRD", //Suriname, Dollars
//  "STD" => "STD", //São Tome and Principe, Dobras
//  "SVC" => "SVC", //El Salvador, Colones
//  "SYP" => "SYP", //Syria, Pounds
//  "SZL" => "SZL", //Swaziland, Emalangeni
//  "THB" => "THB", //Thailand, Baht
//  "TJS" => "TJS", //Tajikistan, Somoni
//  "TMM" => "TMM", //Turkmenistan, Manats
//  "TND" => "TND", //Tunisia, Dinars
//  "TOP" => "TOP", //Tonga, Pa'anga
//  "TRY" => "TRY", //Turkey, New Lira
//  "TTD" => "TTD", //Trinidad and Tobago, Dollars
//  "TVD" => "TVD", //Tuvalu, Tuvalu Dollars
//  "TWD" => "TWD", //Taiwan, New Dollars
//  "TZS" => "TZS", //Tanzania, Shillings
//  "UAH" => "UAH", //Ukraine, Hryvnia
//  "UGX" => "UGX", //Uganda, Shillings
    "USD2" => "$", //United States of America, Dollars
//  "UYU" => "UYU", //Uruguay, Pesos
//  "UZS" => "UZS", //Uzbekistan, Sums
//  "VEB" => "VEB", //Venezuela, Bolivares
//  "VND" => "VND", //Viet Nam, Dong
//  "VUV" => "VUV", //Vanuatu, Vatu
//  "WST" => "WST", //Samoa, Tala
//  "XAF" => "XAF", //Communauté Financière Africaine BEAC, Francs
//  "XAG" => "XAG", //Silver, Ounces
//  "XAU" => "XAU", //Gold, Ounces
//  "XCD" => "XCD", //East Caribbean Dollars
//  "XDR" => "XDR", //International Monetary Fund (IMF) Special Drawing Rights
//  "XOF" => "XOF", //Communauté Financière Africaine BCEAO, Francs
//  "XPD" => "XPD", //Palladium Ounces
//  "XPF" => "XPF", //Comptoirs Français du Pacifique Francs
//  "XPT" => "XPT", //Platinum, Ounces
//  "YER" => "YER", //Yemen, Rials
//  "ZAR" => "ZAR", //South Africa, Rand
//  "ZMK" => "ZMK", //Zambia, Kwacha
//  "ZWD" => "ZWD", //Zimbabwe, Zimbabwe Dollars
);

function dummyForI18n()
{
    // dummy function to let POEdit pick up these strings
    __("€","yaacc"); //Euro Member Countries, Euro
    __("£", "yaacc"); //United Kingdom, Pounds
    __("¥","yaacc"); //Japan, Yen
    __("USD","yaacc"); //United States of America, Dollars
}


?>