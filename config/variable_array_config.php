<?php
include "config_organisation.php";
//$HOST='192.168.1.1';
$HOST='localhost';
$NAME='Altalyst Technologies';
$DATABASE='bank';
$USER='postgres';
$PASSWORD='password';
//$DATABASE="parthamo";
$PORT="5432";
$DATESTYLE="SET DATESTYLE to 'German'";      // 15.10.1970
$FRAMEBORDERCOLOR="#87CEFA";
$FRAMECOLOR="#3340B7";
$TBGCOLOR="#FFFFFF";
$TCOLOR="#FEFEFE";
$SIGNATURE_PATH="../signature";
$DOCUMENT_PATH="../document";
$HIGHLIGHT="onFocus=\"this.style.backgroundColor='aqua' \"  onBlur=\"this.style.backgroundColor='white'\"style=\"font-size:10pt;BACKGROUND-COLOR:#ffffff; BORDER-BOTTOM: #111111 1px solid; BORDER-COLLAPSE: collapse; BORDER-LEFT: #111111 1px solid; BORDER-RIGHT: #111111 1px solid; BORDER-TOP: #111111 1px solid \"";


//------------------------------array---------------------------------------------------------
$loan_type_array=array(
		"kcc"=>"Kishan Credit Card Loan",
		//"sao"=>"SAO Loan",
		"pl"=>"Pledge Loan",
		"lad"=>"LAD Loan",
		//"ofl"=>"Own Fund Loan",
		"kpl"=>"KVP Loan",
		"mt" => "MT-Loan",
		//"mtb" =>"MTB Loan",
		"car"=>"CAR Loan",
		"hbl"=>"House Loan",
		"ser"=>"Service-Loan",
		"sfl"=>"Staff Loan",
		"sgl"=>"SHG Loan",
		"fis"=>"Fisary Loan",
		//"jgl"=>"JLG Loan",
		//"ks"=>"Krishak Somman",
		//"bdl"=>"Bond Loan",
		//"spl"=>"SMP Loan",
		//"nf"=>"Non Farm Loan",
		"all"=>"ALL Loan"
		
);

$inst_array=array('m'=>'Monthly','q'=>'Quarterly');

$alive_array = array (
	"l" => "Alive",
	"d"=>"Dead"
	
);

$title_array=array(
		"mr"=>"Mr",
		"ms"=>"Ms"
		);
$type_of_status_array = array (
                "op" => "opening",
		"cl" => "closed"
		);		
$rel_array = array (
	"hindu" => "Hindu",
	"muslim" => "Muslim",
	"christian" => "Christian");	


$role_of_array=array(
		"normal"=>"Normal",
		"admin"=>"Administrator"
		);
//for passing authority------------------
$type_of_pass_array = array 	(
		"sb" => "Savings",
		"fd" => "Fixed Deposit"
				);
$withdrawn_type_array = array (
		"" => "Active",
		"p" => "Premature",
		"m" => "Mature");
$passing_array = array (
		"0" => "Pending",
		"1" => "Yes",
		"-1" => "No");

//----------------------------------------
$type_of_account1_array = array (
		"sb" => "Saving",
		"hsb" => "Home Saving",
		"ca" => "Current",
		"pfsb" => "PF Saving",
		"rd" => "Recurring Deposit",
		"fd" => "Fixed Deposit",
		"ri" => "Reinvestment",
		"mis"=> "MIS",
		"add" =>"Advance",
		"mt" => "MT-Loan",
		"mtb" => "MTB Loan",
		"ks" => "KS-Loan",
		"ln"=>"Loan",
		"st" => "ST-Loan",
		"lad" => "Loan Against Deposit",
		"pl"=>"Pledge",
		"kcc"=>"Kishan Credit Card",
		"sfl"=>"Staff Loan",
		"nf" => " Non Farm-Loan",
		"ofl"=>"Own Fund Loan",
		"ccl"=>"Cash Credit Loan",
		"kpl"=>"KVP Loan",
		"bdl"=>"Bond Loan",
		"spl"=>"SMP Loan",
		"ser"=>"Personal Service Loan",
		"fis"=>"Fisary Loan",
		"car"=>"Car Loan",
		"sh"=>"Share",
		"sao"=>"SAO-Loan",
		"hbl"=>"House-Loan",
		"jl"=>"Joint Liablity Group SB",
		"sgl"=>"SHG Loan"
);
$type_of_group_array = array (
		"m" => "Male",
		"f" => "Female",
		"u" => "Mixed");

$search_by_array=array(
 		"voter_card"=>"Voter Card",
		"name"=>"Name",
                "account"=>"Account No"
		);
$type_of_account2_array = array (
                "so" => "Sole Account",
		"jn" => "Joint Account",
		"or" => "Organisational",
		"gp" => "Self Help Group",
		"jl" => "Joint Library Group",
 		"nr" => "NREGS",
		"st"=>"Staff",
		"ot" => "Other"
		);
$type_of_change_array = array (
                "so" => "Sole Account",
		"jn" => "Joint Account"
		);	
$account_operation_array = array (
		"si" => "Single operation",
		"jo" => "Joint operation",
		"es" => "Either/Survivor");

$sex_array = array (
		"m" => "Male",
		"f" => "Female");

$customer_type_array = array (
		"m" => "Member",
		"nm" => "Non-Member",
		"shg" => "SHG");
	
$identity_proof_array = array (
	"vo" => "Voter IdCard",
	"pa" => "Passport",
	"pn" => "PAN card",
	"dl" => "Driving license",
	"id" => "Govt. id card");

	
$address_proof_array = array (
	"ra" => "Ration card",
	"vo" => "Voter IdCard",
	"pa" => "Passport",
	"dl" => "Driving license",
	"id" => "Govt. id card",
	"eb" => "Electric bill",
	"tb" => "Telephone bill",
        "gb" => "Gas Book",
	"ot" => "other");
	
$dob_proof_array = array (
	"sc" => "School leaving certificate",
	"pa" => "Passport",
	"dl" => "Driving license",
	"bc" => "Birth certificate");

$bank_withdrawal_particulars_array = array (
	"cash" => "cash",
	//"cheque" => "cheque",
	//"int." => "interest",
	"charges" => "charges");
$bank_deposit_particulars_array = array (
	"cash" => "cash",
	"cheque" => "cheque",
	"int." => "interest",
	//"charges" => "charges"
	);
$farmer_type_array = array (
		"o" => "Own land",
		"b" => "Bhag chashi",
		);
$land_array = array (
		"i" => "Irrigated land",
		"n" => "Non irrigated land"
		);
$fd_type_array = array (
		"s" => "Short Term",
		"m" => "Mid Term",
		"l" => "Long Term");

$withdrawn_type_array = array (
		"" => "Active",
		"p" => "Premature",
		"m" => "Mature");
		
$scheme_array = array (
		"nm" => "Normal Deposit",
		"sn" => "Senior Citizen Deposit"
		);
$particulars_type_array = array (
		"ma" =>  "Monthly Amount",
		"p" => "Penalty",
		"o" => "Others");

//-------------------------------For Retail Shop------------------------------------------
$material_type_array=array(
	"1"=>"Agricultural Inputs",
	"2"=>"Agricultural Implements",
	"3"=>"Agricultural Produces",
	"4"=>"Consumer Goods",
	"5"=>"Office Supply Items",
	"6"=>"Govt. Procurement Scheme Items",
	"7"=>"Midday Meal Scheme Items",
	"9"=>"Other Trading Commodities"
);

$material_group_array=array(
	"fer"=>"Fertilisers",
	"seed"=>"Seeds",
	"ppche"=>"Plant Protection Chemical"
	);
$UOM_array=array(
	"kg"=>"Kilogram",
        "gm"=>"Gram",
	"ltr"=>"Litter",
        "ml"=>"Mililitter",   
	"pcs"=>"Pieces",
	"pkt"=>"Packet"
	);
$party_category_array=array(
	"gvt"=>"Govt./Semi-Govt.",
	"cop"=>"Other Co-Operatives",
	"mem"=>"Member",
	"non"=>"Non-Member"
	);
$party_category_array1=array(
	"non"=>"Non-Member",
	"gvt"=>"Govt./Semi-Govt.",
	"cop"=>"Other Co-Operatives"
	//"mem"=>"Member",
	
	);
$vendor_category_array=array(
	"G"=>"Govt./Semi-Govt.",
	"I"=>"Iffco/Kribho",
	"C"=>"Other Co-Operatives",
	"O"=>"Other Sources",
	);
//------------------------------------------------------------------------------------------
$designation_type_array = array (
	"Member" => "Member",
	"Leader" => "Leader",
	"Sub-Leader" => "Sub-Leader");

$caste_array = array (
	"SC" => "SC",
	"ST" => "ST",
	"OBC" => "OBC",
	"Gen" => "General",
	"min" => "Minority"
);

$customer_qualification_array = array (
		"ill" => "Illeterate",
		"ble" => "Below Eight",
		"ep" => "Eight Pass",
		"sec" => "Secondary",
		"hs" => "Higher Secondary",
		"gra"=> "Graduate",
		"pg" => "Post Graduate"
);

$customer_occupation_array=array(
		"far"=> "Farmar",
 		"bus"=> "Business",
		"ser"=> "Service",
		"pro"=> "Profession",
                "hwf"=> "Housewife",
		"othr"=>"Other"
);
$relation_array=array(
		"fa"=>"Father",
		"mo"=>"Mother",
		"si"=>"Sister",
		"br"=>"Brother",
		"sn"=>"Son",
		"dr"=>"Daughter",
		"hb"=>"Husband",
		"wf"=>"Wife",
		"or"=>"Other"
		);
$designation_orga_array=array(
		"pr"=>"President",
		"vp"=>"Vice-President",
		"ch"=>"Chairman",
		"se"=>"Secretary",
		"as"=>"Assitant Secretary",
		"js"=>"Joint Secretary",
		"ac"=>"Accountant",
		"tr"=>"Treasurer",
		"pc"=>"Principal",
		"hm"=>"Head Master",
		"mg"=>"Manager",
		"st"=>"Staff",
		"op"=>"Operator",
		"ot"=>"Other"
		);
	
	$crop_master_array=array(
		"kh"=>"Kharif",
		"ra"=>"Rabi",
		"bo"=>"Boro"
		);


	$payment_term_array=array(
		1=>"Monthly",
		4=>"Quarterly",
		2=>"Halfyearly",
		12=>"Yearly"
		);



$compute_type_array=array(
		"sp"=>"Simple",
		"mc"=>"Monthly Compound",
		"qc"=>"Quarterty Compound",
		"hc"=>"Halfyearly Compound",
		"yc"=>"Yearly Compound"
); 
$header_type_array=array(
		"LA"=>"Liabilities",
		"AS"=>"Assets",
		"PU"=>"Purchases",
		"SA"=>"Sales",
		"IN"=>"Income",
		"EX"=>"Expenditure"
);
$mtloan_type_array=array(
		//"23201"=>"[23201]medium term(conversion) loan",
		//"23203"=>"[23203]medium term(reschedulement) loan",
		"23207"=>"[23207]medium term farm mechanisation loan",
		"23205"=>"[23205]medium term plantation loan",
		//"23209"=>"[23209]medium term minor imigation loan",
		//"23211"=>"[23211]medium term fishery loan",
		//"23213"=>"[23213]medium term self help group loan",
		"23215"=>"[23215]medium term non farm loan"
		//"23217"=>"[23217]medium term consumer durable loan"
		);

$serloan_type_array=array(
		"23307"=>"[23307]Medium term personal loan"
);


$carloan_type_array=array(
		"23305"=>"[23305]Long term car loan"
);
$fisloan_type_array=array(
		"23211"=>"[23211]Medium Term Fisary Loans"
);

$ksloan_type_array=array(
		"23123"=>"[23123]short term ks loan current",
		//"23203"=>"[23203]medium term(reschedulement) loan",
		//"23207"=>"[23207]medium term farm mechanisation loan",
		//"23205"=>"[23205]medium term plantation loan",
		//"23209"=>"[23209]medium term minor imigation loan",
		//"23211"=>"[23211]medium term fishery loan",
		//"23213"=>"[23213]medium term self help group loan",
		//"23215"=>"[23215]medium term non farm loan"
		//"23217"=>"[23217]medium term consumer durable loan"
		);
		
$jlgl_type_array=array(
		"23119"=>"[23119]short term jlg loan-current",
		"23120"=>"[23120]short term jlg loan-overdue"
		);

$nf_type_array=array(
		"23215"=>"[23215]Short Term Non-ferm Loan-current"
		//"23115"=>"[23115]loan against deposit-current",
);


$add_type_array=array(
	"27215" => "Other Advance(Dr.)",
	"17215" => "Other Advance(Cr.)"
);


$govt_loan_array=array(
		"13101"=>"[13101] Govt. Borrowing(Construction)",
		"13102"=>"[13102] Govt. Borrrowing(Furniture & Fixture)",
		"13103"=>"[13103] Govt. Borrowing(Plant & Machinery)",
		"13199"=>"[13199] Govt. Borrowing(Others)"
		);
$bk_loan_type_array=array(
			"kcc"=>"Krishan Credit Card",
			"shg"=>"Self Help Group",
			"jlg"=>"Joint Liability Group",
			"st"=>"Short Term",
			"od"=>"Overdraft",
			"mt"=>"Medium Term",
			"ks"=>"krishak samman",
			"cc"=>"Cash Credit",
			"pl"=>"Pledge",
			"govt"=>"Govt.",
			"oth"=>"Other"
			);
$ccb_loan_array=array(
		"13201"=>"[13201] Short-Term Borrowing",
		"13202"=>"[13202] Medium Term(Conversion) Borrowing",
		"13203"=>"[13203] MT/LT Re-schedulement Borrowing",
		"13204"=>"[13204] SHG Borrowing",
		"13205"=>"[13205] MT/LT Agriculture Borrowing",
		"13206"=>"[13206] MT/LT Non-Farm Borrowing",
		"13207"=>"[13207] Cash Credit(Agriculture Produces)",
		"13208"=>"[13208] Cash Credit(Gold Loan) Borrowing",
		"13209"=>"[13209] Cash Credit(Agricultural Inputs-Fertiliser)",
		"13210"=>"[13210] Cash Credit(Agricultural Inputs-Seeds etc.)",
		"13211"=>"[13211] Cash Credit(PDS) Borrowing",
		"13212"=>"[13212] Cash Credit(Non-PDS Consumer) Borrowing",
		"13213"=>"[13213] Cash Credit(Mis. Non-Credit) Borrowing",
		"13214"=>"[13214] Borrowing against Term Deposits",
		"13299"=>"[13299] Other Borrowing",
		"13218"=>"[13218] Jlg Borrowing From Scb/ccb"
		);
$comercial_loan_array=array(
		"13301"=>"[13301] Short-Term Borrowing",
		"13302"=>"[13202] Medium Term(Conversion) Borrowing",
		"13303"=>"[13303] Medium Term Borrowing",
		"13304"=>"[13304] Long Term Borrowing",
		"13305"=>"[13305] Cash Credit Borrowing",
		"13306"=>"[13306] Overdraft",
		"13399"=>"[13399] Other Borrowing"
		);
$lad_type_array=array(
		//"23105"=>"[23105]short term agricultural produces pledge loan-current",
		"23115"=>"[23115]Loan against deposit"
		);		
$other_loan_array=array(
		"13401"=>"[13401] Borrowing from Primary CARDB",
		"13402"=>"[13402] Borrowing from SCARDB",
		"13499"=>"[13499] Borrowing from Other Sources"		
		);
$source_type_array=array(
		"ccb"=>"CCB/SCB",
		"cm"=>"Commerial",
		//"po"=>"Post Office",
		"gvt"=>"Government",
		"ot"=>"Others"
		);

$bk_type_array=array(
		"ccb"=>"CCB/SCB",
		"cm"=>"Commerial",
		"po"=>"Post Office",
		"oth"=>"Others"
		);

$pledge_type_array=array(
		"23105"=>"[23105]short term agricultural produces pledge loan-current",
		);
$hbl_type_array=array(
		"23301"=>"[23301]Medium Term house Loan-current"
		
		);


$ccl_type_array=array(
		"23107"=>"[23107]short term consumption(pawning) loan-current"
);
$spl_type_array=array(
		"23117"=>"[23117]short term seed multiplication pledge loan-current",

);
$kpl_type_array=array(
		"23109"=>"[23109]Short Term NSC/KVP/LIP Loan"
		//"23115"=>"[23115]loan against deposit-current",
);
$bdl_type_array=array(
		"23121"=>"[23121]short term bond loan-current"
		//"23115"=>"[23115]loan against deposit-current",
);
$mtbloan_type_array=array(
		"23225"=>"[23225]Medium Term Betal-Vine Loan-current"
		
		);
$sfl_type_array=array(
		"23401"=>"[23401]Staff Loan"
		//"23115"=>"[23115]loan against deposit-current",
);

$ofl_type_array=array(
		"23125"=>"[23125]Own Fund Loan"
		//"23115"=>"[23115]loan against deposit-current",
);
$sao_type_array=array(
		"23101"=>"[23101]Short Term(sao)loan -current"
		//"23115"=>"[23115]loan against deposit-current",
);
$shgl_type_array=array(
		"23213"=>"[23213]Medium term loan",
		"23113"=>"[23113]short term loan"
		);
$crop_array=array(
		"a"=>"Amon",
		"b"=>"Boro",
		"r"=>"Rabi"

		);
$module_desc_array=array(
		"sb"=>"Savings",
		"fd"=>"Fixed Deposit",
		"rd"=>"Recurring Deposit",
		"ri"=>"Reinvestment Deposit",
		"mis"=>"MIS",
		"mt"=>"MTLoan",
		"ks"=>"KSLoan",
		"c"=>"Customer",
		"pl"=>"Pledge",
		"nf"=>"Non Farm",
		"shg"=>"Self Help Group",
		"m"=>"Member",
		"kcc"=>"KCC"
);
$pl_doc_type_array=array(
		"fd"=>"FD",
		"rd"=>"RD",
		"ri"=>"RI",
		"mis"=>"MIS",
		"ut"=>"Utensil",
		"oth"=>"Other"
		);

$ccl_doc_type_array=array(
		"fd"=>"FD",
		"rd"=>"RD",
		"ri"=>"RI",
		"mis"=>"MIS",
		"lic"=>"LIC",
		"kvp"=>"KVP",
		"nsc"=>"NSC",
		"oth"=>"Other"
		);
$kpl_doc_type_array=array(
		
		"lic"=>"LIC",
		"kvp"=>"KVP",
		"nsc"=>"NSC",
		"oth"=>"Other"
		);
		
$account_type_bank=array(
		"sb"=>"Savings",
		"ca"=>"Current",
		"ln"=>"Loan"
		);
$in_type_bank=array(
		"fd"=>"FD",
		"rd"=>"RD",
		"ri"=>"RI",
		"oth"=>"Other"
		//"po"=>"PO"
		);
$month_array=array(
		"1"=>"January",
		"2"=>"February",
		"3"=>"March",
		"4"=>"April",
		"5"=>"May",
		"6"=>"June",
		"7"=>"July",
		"8"=>"August",
		"9"=>"September",
		"10"=>"October",
		"11"=>"November",
		"12"=>"December"
		);
$mode_array=array(
		"cash"=>"cash",
		"ch"=>"cheque",
		"trf"=>"transfer",
		"dft"=>"draft"
		);
/*$asset_type_array=array(
		"ia"=>"IMMOVABLE ASSET(21100)",
		"fm"=>"FURNITURE & MACHINERY(21200)",
		"vu"=>"VEHICLES & UTILITIES(21300)",
		"ls"=>"LIVESTOCKS(21400)",
		"mfa"=>"MISCELLANEOUS FIXED ASSETS(21900)"
		);
*/

$asset_type_array=array(
		"21100"=>"IMMOVABLE ASSET(21100)",
		"21200"=>"FURNITURE & MACHINERY(21200)",
		"21300"=>"VEHICLES & UTILITIES(21300)",
		"21400"=>"LIVESTOCKS(21400)",
		"21900"=>"MISCELLANEOUS FIXED ASSETS(21900)"
		);


$immovable_asset_array=array(
		"21101"=>"[21101]Land",
		"21102"=>"[21102]Godown & Building",
		"21103"=>"[21103]Implements Shed",
		"21104"=>"[21104]Cold Storage Building",
		"21105"=>"[21105]Shops/Qutiets",
		"21106"=>"[21106]Agro Service Center",
		"21107"=>"[21107]Plant",
		"21108"=>"[21108]Iron Safe",
		"21109"=>"[21109]Other Immovable Asset",
		"21190"=>"[21190]Dead Stock"
		);

$furniture_machinery_asset_array=array(
		"21201"=>"[21201]Fumiture & Fixture",
		"21202"=>"[21202]Machinery",
		"21203"=>"[21203]Computer & Accessories",
		"21204"=>"[21204]Electrical installation",
		"21205"=>"[21205]Telephone Installation",
		"21206"=>"[21206]Pipe Line Installation",
		"21207"=>"[21207]Sub-marshible Installation",
		"21208"=>"[21208]Fire- Fitting Installation",
		"21209"=>"[21209]Mini-Deep"
		);
$vehicles_utilities_array=array(
		"21301"=>"[21301]Vehicles",
		"21302"=>"[21302]Tractors/Power Tillers",
		"21303"=>"[21303]Agricultural Implements",
		"21304"=>"[21304]Community Irrigation Facillities",
		"21305"=>"[21305]Other Utilities",
		
		);
$livestock_array=array(
		"21401"=>"[21401]Live Stock",
		
		);

$miscellaneous_fixed_array=array(
		"21901"=>"[21901]Miscellaneous Fixed Assets",
		
		);


$depreciation_method_array=array(
	"re"=>"Reducing",
	"st"=>"Staight",
	"no"=>"None"
);
$all_assets_array=array(
		"21101"=>"[21101]Land",
		"21102"=>"[21102]Godown & Building",
		"21103"=>"[21103]Implements Shed",
		"21104"=>"[21104]Cold Storage Building",
		"21105"=>"[21105]Shops/Qutiets",
		"21106"=>"[21106]Agro Service Center",
		"21107"=>"[21107]Plant",
		"21108"=>"[21108]Iron Safe",
		"21109"=>"[21109]Other Immovable Asset",
		"21190"=>"[21190]Dead Stock",
		"21201"=>"[21201]Fumiture & Fixture",
		"21202"=>"[21202]Machinery",
		"21203"=>"[21203]Computer & Accessories",
		"21204"=>"[21204]Electrical installation",
		"21209"=>"[21209]Mini-Deep",
		"21301"=>"[21301]Vehicles",
		"21302"=>"[21302]Tractors/Power Tillers",
		"21303"=>"[21303]Agricultural Implements",
		"21304"=>"[21304]Community Irrigation Facillities",
		"21305"=>"[21305]Other Utilities",
		"21401"=>"[21401]Live Stock",
		"21901"=>"[21901]Miscellaneous Fixed Assets"	
	
	);
$purchase_mode_array=array(
		"cash"=>"cash",
		"ch"=>"cheque",
		"crd"=>"credit"
		);
$retail_pu_mode_array=array(
		"ca"=>"cash",
		"ch"=>"cheque",
		"cr"=>"credit"
		);
$sales_type_array=array(
		"fu"=>"Fully",
		"pa"=>"Partly"
		);
$loan_repay_mode_array=array(
		"cash"=>"cash",
		"ch"=>"cheque",
		"tf"=>"transfer"
		);


$loan_module_array=array(
		"all"=>"All",
		"kcc"=>"Kishan Credit Card",
		"sao"=>"SAO Loan",
		"ser"=>"Service Loan (HRL)",
		"kpl"=>"KVP Loan (PL)",
		"bdl"=>"Bond Loan",
		"pl"=>"Pledge",
		"ccl"=>"Cash Credit Loan",
		"mt" => "MT-Loan",
		"ks" => "KS-Loan",
		"nf" => " Non Farm-Loan",
		"car" => "Car Loan",
		"fis" => " Fishery Loan",
		"spl"=>"SMP Loan",
		"sgl"=>"SHG Loan",
		"sfl"=>"Staff Loan",
		"lad"=>"LAD Loan",
		"ofl"=>"Own Fund Loan"
);

?>
