<?php
#| Apartment     |
#| Detached      |
#| Townhouse     |
#| Link          |
#| Stacked       |
#| Semi Detached |
#| Loft          |
#============
#+---------------+--------------------+
#| D.            | Detached           |
#| C.            | Condo Apt          |
#| S.            | Semi-Detached      |
#| A.            | Att/Row/Twnhouse   |
#| 2.            | Comm Element Condo |
#| L.            | Link               |
#| T.            | Condo Townhouse    |
#| K.            | Triplex            |
#| J.            | Duplex             |
#| A7.           | Parking Space      |
#| H.            | Det Condo          |
#| N.            | Fourplex           |
#| M.            | Multiplex          |
#| ~.            | Upper Level        |
#| Y.            | Store W/Apt/Offc   |
#| E.            | Co-Op Apt          |
#| A6.           | Locker             |
#| W.            | Co-Ownership Apt   |
#| 8.            | Room               |
#| 6.            | Det W/Com Elements |
#| 3.            | Leasehold Condo    |
#| P.            | Semi-Det Condo     |
#| Z.            | Time Share         |
#+---------------+--------------------+

#mysql> select distinct type_own_srch  from IDX ;
#+------------------------+
#| type_own_srch          |
#+------------------------+
#| Condo Apartment        |
#| Detached               |
#| Office                 |
#| Semi-Detached          |
#| Commercial Retail      |
#| Common Element Condo   |
#| Lower Level            |
#| Industrial             |
#| Parking Space          |
#| Sale Of Business       |
#| Duplex                 |
#| Locker                 |
#| Land                   |
#| Att/Row/Townhouse      |
#| Triplex                |
#| Investment             |
#| Store W Apt/Office     |
#| Room                   |
#| Multiplex              |
#| Condo Townhouse        |
#| Vacant Land            |
#| Other                  |
#| Co-op Apartment        |
#| Fourplex               |
#| Co-Ownership Apartment |
#| Upper Level            |
#| Shared Room            |
#| Link                   |
#| Detached Condo         |
#| Leasehold Condo        |
#| Farm                   |
#| Cottage                |
#| MobileTrailer          |
#| Rural Residential      |
#| Semi-Detached Condo    |
#| Modular Home           |
#| Timeshare              |
#| Vacant Land Condo      |
#+------------------------+


  if ($rtype == '') {
    $twhere="";
   }else if ( $rtype == 'condo-townhouse' ) {
    $twhere=" and  ( type_own_srch in ('.T.') or  type_own_srch in ('Condo Townhouse') )";
   }else if ($rtype == 'Apartment' || $rtype == 'condo' ) {
    $twhere=" and ( type_own_srch in ('.E.', '.W.', '.2.' , '.C.' ,'.P.','.T.','.H.') or  type_own_srch in ('Co-op Apartment','Co-Ownership Apartment','Common Element Condo','Condo Apartment','Semi-Detached Condo','Detached Condo') ) ";
   }else if ($rtype == 'Link' ) {
    $twhere=" and ( type_own_srch in ('.L.') or  type_own_srch in ('Link') )";
   }else if ($rtype == 'Townhouse' || $rtype == 'townhouse') {
    $twhere=" and ( type_own_srch in ('.A.', '.P.', 'M','.K.','.6.','.7.','.N.') or type_own_srch in ('Att/Row/Townhouse', 'Semi-Det Condo ', 'Multiplex','Triplex','Multiplex','Fourplex') ) ";
   }else if ($rtype == 'Detached' || $rtype == 'house' ) {
    $twhere=" and ( type_own_srch in ('.D.') or type_own_srch in ('Detached') )";
   }else if ($rtype == 'Semi-Detached' || $rtype == 'semi-detached' ) {
    $twhere=" and ( type_own_srch in ('.S.') or  type_own_srch in ('Semi-Detached') )";
   }else if ($rtype == 'parking' ) {
    $twhere=" and ( type_own_srch in ('.A7.') or  type_own_srch in ('Parking Space') ) ";
   }else{
    $twhere="";
   }
?>
