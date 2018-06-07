USETEXTLINKS = 1
// Configures whether the tree is fully open upon loading of the page, or whether
// only the root node is visible.
STARTALLOPEN = 0
// Specify if the images are in a subdirectory;
ICONPATH = "../image/";
foldersTree = gFld("<i>Esociety</i>", "../main/myzone.php?menu=system")
  foldersTree.treeID = "Frameset"
  
//------------------------------------myzone-----------------------------------------------------------

aux1 = insFld(foldersTree, gFld("Documentations", "../main/myzone.php?menu=myzone"))
		//insDoc(aux1, gLnk("R", "WHY NETWARE", "../document/facility.html"))
		insDoc(aux1, gLnk("R", "Manual", "../document/manual.html"))
		insDoc(aux1, gLnk("R", "Data Entry Rules", "../document/manual.html"))
		insDoc(aux1, gLnk("R", "Audit Computer Enviroment", "../manual/audit_com_env.html"))
		aux2 = insFld(aux1, gFld("Audit Rating", "../main/myzone.php"))
		insDoc(aux2, gLnk("R", "NEW", "../manual/audit_rat_class.html"))
		insDoc(aux2, gLnk("R", "OLD", "../manual/old.html"))

//--------------------------------------SET UP---------------------------------------------------------
aux1 = insFld(foldersTree, gFld("Setup", "../main/myzone.php?menu=myzone"))
         //aux2 = insFld(aux1, gFld("Setup", "../main/myzone.php?menu=myzone"))
		insDoc(aux1, gLnk("R", "Staff", "../main/configuration.php?menu=myzone&op=s"))
		insDoc(aux1, gLnk("R", "Entry Permission", "../main/permission.php?menu=myzone"))
		insDoc(aux1, gLnk("R", "Entry Report", "../main/entry_report.php?menu=myzone"))
		//insDoc(aux1, gLnk("R", "Entry Chart", "../main/entry_report1.php?menu=myzone"))
		insDoc(aux1, gLnk("R", "Opening", "../main/opening_balance.php?menu=myzone"))
		insDoc(aux1, gLnk("R", "NPA Form", "../main/npa.php"))

  	  aux2 =insFld(aux1, gFld("MIS Reports", "../main/myzone.php"))
	        insDoc(aux2, gLnk("R", "Risk Weighted Assets", "../main/asst_hdr_ldr.php"))

	  aux3 =insFld(aux2, gFld("RATIO", "../main/myzone.php"))
		insDoc(aux3, gLnk("R", "Ratio Master", "../main/ratio_mas.php"))
      		insDoc(aux3, gLnk("R", "Ratio Specification", "../main/ratio_spcfctn.php"))
                insDoc(aux3, gLnk("R", "Ratio Specification Derived", "../main/ratio_spc_drvd.php"))
/*
//----------this folder will be under setup folder--------------
	aux2 = insFld(aux1, gFld("Retail", "../main/myzone.php"))
		insDoc(aux2, gLnk("R", "Opening Material", "../retail/opening_material_group.php?menu=myzone"))
		insDoc(aux2, gLnk("R", "Opening Gl Code", "../retail/opening_gl_code.php?menu=myzone"))
*/      
	 aux2 =insFld(aux1, gFld("Deposit", "../main/myzone.php"))
      		insDoc(aux2, gLnk("R", "Interest Rate Master", "../main/configuration.php?op=d"))
			insDoc(aux2, gLnk("R", "Interest Rate Calculate", "../sb/sb_calculate_interest.php"))
	aux2 = insFld(aux1, gFld("Reserve", "../main/myzone.php"))
		//insDoc(aux2, gLnk("R", "All Fund", "../main/reserve_surplus_op.php?menu=myzone"))
		insDoc(aux2, gLnk("R", "Policy", "../main/reserve_surplus_cur.php?menu=myzone"))
	
	 aux2 =insFld(aux1, gFld("Dividend", "../main/dividend.php?menu=myzone&op=d"))

/*
         aux2=insFld(aux1, gFld("Passing Authority", "../main/myzone.php"))  
                insDoc(aux2, gLnk("R", "Dirrect Withdraw", "../pass/withdraw.php?op=d"))
                insDoc(aux2, gLnk("R", "Remarks Master", "../pass/remark.php?op=d"))              

 	//add for payroll
                
            aux2=insFld(aux1, gFld("Salary & PF ", "../main/myzone.php"))
                insDoc(aux2, gLnk("R", "Salary Parameter Setting", "../payroll/sal_param.php"))
		insDoc(aux2, gLnk("R", "PF Investment Master", "../payroll/pf_invst.php"))


	   aux2 = insFld(aux1, gFld("Mini", "../main/myzone.php"))
		insDoc(aux2, gLnk("R", "Operator Commission Master", "../mini/commission_rate_ef.php"))
		insDoc(aux2, gLnk("R", "Crop Rate Master", "../mini/crop_master_tan.php"))
		insDoc(aux2, gLnk("R", "GLCode Creation", "../mini/mini_gl_mas_cd_link.php"))
		insDoc(aux2, gLnk("R", "Sundry Expenses", "../mini/sundry_expenses.php"))
*/

       //add sas

	       // insDoc(aux1, gLnk("R", "Fixed Asset", "../main/configuration.php?menu=myzone&op=fa"))
	      //insDoc(aux1, gLnk("R", "Deposit", "../main/configuration.php?menu=myzone&op=d"))
		//insDoc(aux1, gLnk("R", "Loan", "../main/configuration.php?menu=myzone&op=ln"))
		insDoc(aux1, gLnk("R", "Loan", "../main/loan.php?menu=myzone&op=ln"))
		insDoc(aux1, gLnk("R", "Land", "../main/configuration.php?menu=myzone&op=l"))
      		//insDoc(aux1, gLnk("T", "Log Off", "../index.php"))
/*
//-================================================================================================
	aux1 = insFld(foldersTree, gFld("Employee Salary Structure", "../payroll/main.php"))
	       insDoc(aux1, gLnk("R", "Provident Fund Loan", "../payroll/pf_main.php"))
       aux2 = insFld(aux1, gFld("Adhoc Grant", "../main/myzone.php?menu=rsh"))
                insDoc(aux2, gLnk("R", "Master", "../payroll/ad_mas.php"))
      		insDoc(aux2, gLnk("R", "Disbursement", "../payroll/ad_dtl.php"))
       //insDoc(aux1, gLnk("R", "Service Bond Loan", "../payroll/stf_pf_loan_dtl.php?op=pr"))
       	 insDoc(aux2, gLnk("R", "Report", "../payroll/ad_report1.php"))
       	 insDoc(aux1, gLnk("R", "Holiday Master", "../payroll/hme.php?op=pr"))
      // insDoc(aux1, gLnk("R", "Master Creation", "../payroll/mas_creation.php?op=pr"))	
      // insDoc(aux1, gLnk("R", "Attendence & Leave Details", "../payroll/details.php?op=pr"))
        insDoc(aux1, gLnk("R", "Attendence Details", "../payroll/ead.php?op=pr"))
       // insDoc(aux1, gLnk("R", "Overtime Payment", "../payroll/ot.php?op=pr"))
        insDoc(aux1, gLnk("R", "Report", "../payroll/report.php"))	
        insDoc(aux1, gLnk("R", "User Manual", "../payroll/manual.html"))  
*/
//---------------------Customer Module....................................
aux1 = insFld(foldersTree, gFld("Customer", "../main/myzone.php?menu=cust"))
     insDoc(aux1, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=cust"))
     insDoc(aux1, gLnk("R", "Statement", "../customer/customer_statement.php?menu=cust"))
     insDoc(aux1, gLnk("R", "New", "../customer/customer_account_ef.php?menu=cust"))
     insDoc(aux1, gLnk("R", "Modify", "../customer/customer_account_ef.php?menu=cust&up=p"))
     insDoc(aux1, gLnk("R", "Report", "../customer/customer_report.php?menu=cust"))

//======================================SHARE MODULE=========================================
aux2 = insFld(foldersTree, gFld("Share", "../share/share_main.php?menu=sh"))
//aux2 = insFld(aux1, gFld("Share", "../main/nextaccount.php?menu=sh"))
	insDoc(aux2, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=sh"))
        insDoc(aux2, gLnk("R", "Issue", "../share/share_ledger_ef.php?menu=sh&issue=1"))
	insDoc(aux2, gLnk("R", "BuyBack", "../share/share_ledger_ef.php?menu=sh&buyback=1"))
	insDoc(aux2, gLnk("R", "Statement", "../share/share_statement.php?menu=sh"))
	//insDoc(aux2, gLnk("R", "Main", "../share/share_main.php?menu=sh"))
	insDoc(aux2, gLnk("R", "Report", "../share/share_report.php?menu=sh"))
        insDoc(aux2, gLnk("R", "Closing", "../share/sh_ledger_wf.php?menu=sh&close=1"))


//======================================DEPOSIT MODULE=========================================
    	aux2 = insFld(foldersTree, gFld("Deposit", "../main/myzone.php?menu=deposit"))
// Saving Module .................................
	aux3 = insFld(aux2, gFld("Saving", "../main/nextaccount.php?menu=sb"))
      	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=sb"))
      	insDoc(aux3, gLnk("R", "Deposits", "../sb/sb_ledger_ef.php?menu=sb&deposit=1"))
      	insDoc(aux3, gLnk("R", "Withdrawal", "../sb/sb_ledger_ef.php?menu=sb&withdrawal=1"))
//	insDoc(aux3, gLnk("R", "Checking", "../sb/tran_dtl.php?menu=sb"))
	insDoc(aux3, gLnk("R", "Statement", "../sb/sb_account_statement.php?menu=sb"))
      	insDoc(aux3, gLnk("R", "Scroll", "../general/scroll.php?menu=sb"))
      	//insDoc(aux3, gLnk("R", "Summary","../sb/sb_summary.php?menu=sb"))
      	insDoc(aux3, gLnk("R", "Report", "../sb/sb_report.php?menu=sb"))
      	insDoc(aux3, gLnk("R", "Closing", "../sb/sb_ledger_cef.php?menu=sb"))

//---------------------Fixed Deposit Module .........................
aux3 = 	insFld(aux2, gFld("FD", "../main/nextaccount.php?menu=fd"))
      	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=fd"))
     	insDoc(aux3, gLnk("R", "Deposit", "../fd/fd_ledger_ef.php?menu=fd"))
      	insDoc(aux3, gLnk("R", "Withdrawal", "../fd/fd_ledger_wf.php?menu=fd"))
	insDoc(aux3, gLnk("R", "Renewal", "../fd/renew.php?menu=fd"))
      	insDoc(aux3, gLnk("R", "Statement", "../fd/fd_statement.php?menu=fd"))
      //insDoc(aux3, gLnk("R", "ReIssue", "../main/dev_page.html"))
      	insDoc(aux3, gLnk("R", "Scroll", "../general/scroll.php?menu=fd"))
      //insDoc(aux3, gLnk("R", "Summary", "../main/dev_page.html"))
      	insDoc(aux3, gLnk("R", "Report", "../fd/fd_report.php?menu=fd"))
      	//insDoc(aux3, gLnk("R", "Renewal", "../fd/bk_investment.php?menu=fd"))
//-------------------------ReInvestment Deposit Module.......................
aux3 = 	insFld(aux2, gFld("RI", "../main/nextaccount.php?menu=ri"))
     	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=ri"))
      	insDoc(aux3, gLnk("R", "Deposit", "../ri/ri_ledger_ef.php?menu=ri"))
      	insDoc(aux3, gLnk("R", "Withdrawal", "../ri/ri_ledger_wf.php?menu=ri"))
	insDoc(aux3, gLnk("R", "Renewal", "../ri/renew.php?menu=ri"))
      	insDoc(aux3, gLnk("R", "Statement", "../ri/ri_statement.php?menu=ri"))
      //insDoc(aux3, gLnk("R", "ReIssue", "../main/dev_page.html"))
      	insDoc(aux3, gLnk("R", "Scroll", "../general/scroll.php?menu=ri"))
      //insDoc(aux3, gLnk("R", "Summary", "../main/dev_page.html"))
      	insDoc(aux3, gLnk("R", "Report", "../ri/ri_report.php?menu=ri"))
//-----------------------Recurring Deposit ...................................  
aux3 =	insFld(aux2, gFld("RD", "../main/nextaccount.php?menu=rd"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=rd"))
      	insDoc(aux3, gLnk("R", "Deposit", "../rd/rd_ledger_ef.php?menu=rd"))
      	insDoc(aux3, gLnk("R", "Withdrawal", "../rd/rd_ledger_wf.php?menu=rd"))
      	insDoc(aux3, gLnk("R", "Statement", "../rd/rd_statement.php?menu=rd"))
	insDoc(aux3, gLnk("R", "Scroll", "../general/scroll.php?menu=rd"))
      	//insDoc(aux3, gLnk("R", "Summary", "../main/dev_page.html"))
      	insDoc(aux3, gLnk("R", "Report", "../rd/rd_report.php?menu=rd"))
//------------------------HSB Module ........................................... 
/*aux3 =	insFld(aux2, gFld("HSB", "../main/nextaccount.php?menu=hsb"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=hsb"))
      	insDoc(aux3, gLnk("R", "Deposit", "../hsb/hsb_ledger_ef.php?menu=hsb"))
      	insDoc(aux3, gLnk("R", "Withdrawal", "../hsb/hsb_ledger_wf.php?menu=hsb"))
      	insDoc(aux3, gLnk("R", "Statement", "../hsb/hsb_statement.php?menu=hsb"))
	insDoc(aux3, gLnk("R", "Scroll", "../general/scroll.php?menu=hsb"))
	insDoc(aux3, gLnk("R", "Commission", "../hsb/agent_search.php?menu=hsb"))
      	insDoc(aux3, gLnk("R", "Report", "../hsb/hsb_report.php?menu=hsb"))*/
//------------------------MIS Module ........................................... 
aux3 = insFld(aux2, gFld("MIS", "../main/nextaccount.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Existing", "../mis/mis_op.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Deposit", "../mis/mis_ledger_ef.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Withdrawal", "../mis/mis_ledger_ufi.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Statement", "../mis/mis_statement.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Scroll", "../general/scroll.php?menu=mis"))
      //insDoc(aux3, gLnk("R", "Summary", "../general/summary_report.php?menu=mis"))
      insDoc(aux3, gLnk("R", "Report", "../mis/mis_report.php?menu=mis"))
//------------------------Deposit Report Module ........................................... 

//-------------------------Passing Authority-------------------------------------------------
/*
      aux3 = insFld(aux2, gFld("Passing Authority", "../pass/pass_date.php"))
      aux3 = insFld(aux2, gFld("Withdrawl Final Submit", "../pass/final.php"))


aux3 = insFld(aux2, gFld("Deposit Report", ""))
       insDoc(aux3, gLnk("R", "Report", "../report/deposite_report.php?menu=*"))
 */     

//--------------------------------------------------------------------------------------------
     	aux2 = insFld(foldersTree, gFld("Loan", "../main/myzone.php?menu=loan"))
        
aux3 = insFld(aux2, gFld("KCC", "../general/loan_main.php?menu=kcc"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=kcc"))
	insDoc(aux3, gLnk("R", "Existing", "../kcc/kcc_loan_balance_ef.php?menu=kcc"))
	insDoc(aux3, gLnk("R", "Issue", "../kcc/kcc_loan_issue.php?menu=kcc"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=kcc"))
       	insDoc(aux3, gLnk("R", "Statement", "../kcc/kcc_loan_statement.php?menu=kcc"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=kcc"))
		insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=kcc"))

//----------------------------------SAO MODULE-----------------------------------------------------------


aux3 = insFld(aux2, gFld("SAO", "../general/loan_main.php?menu=sao"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=sao"))
	insDoc(aux3, gLnk("R", "Existing", "../sao/sao_loan_balance_ef.php?menu=sao"))
	insDoc(aux3, gLnk("R", "Issue", "../sao/sao_loan_issue.php?menu=sao"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=sao"))
     	insDoc(aux3, gLnk("R", "Statement", "../sao/sao_loan_statement.php?menu=sao"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=sao"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=sao"))


//------------------------------PLEDGE MODULE -----------------------------------------------
/*	aux3 = insFld(aux2, gFld("Pledge", "../general/loan_main.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Existing", "../pl/pl_loan_balance_ef.php?menu=pl"))
        insDoc(aux3, gLnk("R", "Issue", "../pl/pl_loan_issue_ef.php?menu=pl"))
	//insDoc(aux3, gLnk("R", "Repay", "../pl/pl_loan_repayment.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Statement", "../pl/pl_statement.php?menu=pl"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=pl"))

*/
//----------------------------------LAD--------------------------------------------
	aux3 = insFld(aux2, gFld("LAD", "../general/loan_main.php?menu=lad"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=lad"))
	insDoc(aux3, gLnk("R", "Existing", "../lad/lad_loan_balance_ef.php?menu=lad"))
        insDoc(aux3, gLnk("R", "Issue", "../lad/lad_loan_issue_ef.php?menu=lad"))
	//insDoc(aux3, gLnk("R", "Repay", "../pl/pl_loan_repayment.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=lad"))
	insDoc(aux3, gLnk("R", "Statement", "../lad/lad_statement.php?menu=lad"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=lad"))
/*
//----------------------------MT LOAN MODULE (installment)-----------------------------------------------
 	aux3 = insFld(aux2, gFld("MT-Loan", "../general/loan_main.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=mt"))
        insDoc(aux3, gLnk("R", "Issue", "../mtloan/mt_loan_issue_ef.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Existing", "../mtloan/mt_loan_balance_ef.php?menu=mt"))
        //insDoc(aux3, gLnk("R", "Repay", "../mtloan/mtl_loan_repayment.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Statement", "../mtloan/mt_statement.php?menu=mt"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=mt"))
*/	
//----------------------------MT LOAN MODULE (normal)-----------------------------------------------
 /*	aux3 = insFld(aux2, gFld("MT-Loan", "../general/loan_main.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Existing", "../mtloan/mtl_loan_balance_ef.php?menu=mt"))
        insDoc(aux3, gLnk("R", "Issue", "../mtloan/mt_loan_issue_ef.php?menu=mt"))
	//insDoc(aux3, gLnk("R", "Repay", "../mtloan/mtl_loan_repayment.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Statement", "../mtloan/mtloan_statement.php?menu=mt"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=mt"))

//-----------------------------MTB LOAN MODULE -----------------------------------------------
 	aux3 = insFld(aux2, gFld("MTB Loan","../general/loan_main.php?menu=mtb"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=mtb"))
	insDoc(aux3, gLnk("R", "Existing", "../mtb/mtb_loan_balance_ef.php?menu=mtb"))
        insDoc(aux3, gLnk("R", "Issue", "../mtb/mtb_loan_issue_ef.php?menu=mtb"))
	//insDoc(aux3, gLnk("R", "Repay", "../pl/pl_loan_repayment.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=mtb"))
	insDoc(aux3, gLnk("R", "Statement", "../mtb/mtb_statement.php?menu=mtb"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=pl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=mtb"))

//-----------------------------KS LOAN MODULE -----------------------------------------------
 	aux3 = insFld(aux2, gFld("KS-Loan", "../general/loan_main.php?menu=ks"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=ks"))
        insDoc(aux3, gLnk("R", "Issue", "../ksloan/ksloan_ledger_ef.php?menu=ks"))
	insDoc(aux3, gLnk("R", "Existing", "../ksloan/ksl_loan_balance_ef.php?menu=ks"))
        //insDoc(aux3, gLnk("R", "Repay", "../ksloan/ksl_loan_repayment.php?menu=ks"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=ks"))
	insDoc(aux3, gLnk("R", "Statement", "../ksloan/ksloan_statement.php?menu=ks"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=ks"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=ks"))

*/
//--------------------------------------Cash Credit Loan----------------------------------------
	aux3 = insFld(aux2, gFld("CC-Loan", "../general/loan_main.php?menu=ccl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=ccl"))
	insDoc(aux3, gLnk("R", "Existing", "../ccl/ccl_loan_balance_ef.php?menu=ccl"))
        insDoc(aux3, gLnk("R", "Issue", "../ccl/ccl_loan_issue_ef.php?menu=ccl"))
	//insDoc(aux3, gLnk("R", "Repay", "../ccl/ccl_loan_repayment.php?menu=ccl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=ccl"))
	insDoc(aux3, gLnk("R", "Statement", "../ccl/ccl_statement.php?menu=ccl"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=ccl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=ccl"))

//----------------------SERVICE Module .........................................................

	aux3 = insFld(aux2, gFld("Personal-Service-Loan", "../general/loan_main.php?menu=ser"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=ser"))
	insDoc(aux3, gLnk("R", "Existing", "../service/service_loan_balance_ef.php?menu=ser"))
        insDoc(aux3, gLnk("R", "Issue", "../service/service_loan_issue_ef.php?menu=ser"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=ser"))
	insDoc(aux3, gLnk("R", "Statement", "../service/service_statement.php?menu=ser"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=ser"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=ser"))
	

//--------------------------------------KVP LOAN----------------------------------------
	aux3 = insFld(aux2, gFld("KVP-Loan (PL)", "../general/loan_main.php?menu=kpl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=kpl"))
	insDoc(aux3, gLnk("R", "Existing", "../kpl/kpl_loan_balance_ef.php?menu=kpl"))
        insDoc(aux3, gLnk("R", "Issue", "../kpl/kpl_loan_issue_ef.php?menu=kpl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=kpl"))
	//insDoc(aux3, gLnk("R", "Repay", "../kpl/kpl_loan_repayment.php?menu=kpl"))
	insDoc(aux3, gLnk("R", "Statement", "../kpl/kpl_statement.php?menu=kpl"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=kpl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=kpl"))


//--------------------------------------BOND LOAN----------------------------------------
/*	aux3 = insFld(aux2, gFld("Bond-Loan", "../general/loan_main.php?menu=bdl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=bdl"))
	insDoc(aux3, gLnk("R", "Existing", "../bdl/bdl_loan_balance_ef.php?menu=bdl"))
        insDoc(aux3, gLnk("R", "Issue", "../bdl/bdl_loan_issue_ef.php?menu=bdl"))
	//insDoc(aux3, gLnk("R", "Repay", "../bdl/bdl_loan_repayment.php?menu=bdl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=bdl"))
	insDoc(aux3, gLnk("R", "Statement", "../bdl/bdl_statement.php?menu=bdl"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=bdl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=bdl"))

//--------------------------------------SMP----------------------------------------
	aux3 = insFld(aux2, gFld("SMP-Loan", "../general/loan_main.php?menu=spl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=spl"))
	insDoc(aux3, gLnk("R", "Existing", "../spl/spl_loan_balance_ef.php?menu=spl"))
        insDoc(aux3, gLnk("R", "Issue", "../spl/spl_loan_issue_ef.php?menu=spl"))
	//insDoc(aux3, gLnk("R", "Repay", "../spl/spl_loan_repayment.php?menu=spl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=spl"))
	insDoc(aux3, gLnk("R", "Statement", "../spl/spl_statement.php?menu=spl"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=spl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=spl"))

*/
//----------------------------------------STAFF LOAN----------------------------------------
	aux3 = insFld(aux2, gFld("Staff", "../general/loan_main.php?menu=sfl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=sfl"))
	insDoc(aux3, gLnk("R", "Existing", "../sfl/sfl_loan_balance_ef.php?menu=sfl"))
        insDoc(aux3, gLnk("R", "Issue", "../sfl/sfl_loan_issue_ef.php?menu=sfl"))
	//insDoc(aux3, gLnk("R", "Repay", "../sfl/sfl_loan_repayment.php?menu=sfl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=sfl"))
	insDoc(aux3, gLnk("R", "Statement", "../sfl/sfl_statement.php?menu=sfl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=sfl"))


//-----------------------------HOUSE LOAN MODULE -----------------------------------------------
	aux3 = insFld(aux2, gFld("HOUSE-Loan", "../general/loan_main.php?menu=house"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=house"))
	//insDoc(aux3, gLnk("R", "EMI Calculation", "../houseloan/emi.php?menu=house"))
        insDoc(aux3, gLnk("R", "Issue", "../houseloan/houseloan_ledger_ef.php?menu=house"))
	insDoc(aux3, gLnk("R", "Existing", "../houseloan/house_loan_balance_ef.php?menu=house"))
        //insDoc(aux3, gLnk("R", "Repay", "../houseloan/house_loan_repay.php?menu=house"))

	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=house"))

	insDoc(aux3, gLnk("R", "Statement", "../houseloan/houseloan_statement.php?menu=house"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=house"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=house"))

//----------------------------------------OWN FUND LOAN----------------------------------------
	aux3 = insFld(aux2, gFld("Own Fund", "../general/loan_main.php?menu=ofl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=ofl"))
	insDoc(aux3, gLnk("R", "Existing", "../ofl/ofl_loan_balance_ef.php?menu=ofl"))
        insDoc(aux3, gLnk("R", "Issue", "../ofl/ofl_loan_issue_ef.php?menu=ofl"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=ofl"))
	insDoc(aux3, gLnk("R", "Statement", "../ofl/ofl_statement.php?menu=ofl"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=onf"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=ofl"))
      

//----------------------------------------NON FARM LOAN----------------------------------------
	/*aux3 = insFld(aux2, gFld("Non Farm", "../general/loan_main.php?menu=nf"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=nf"))
	insDoc(aux3, gLnk("R", "Existing", "../nf/nf_loan_balance_ef.php?menu=nf"))
        insDoc(aux3, gLnk("R", "Issue", "../nf/nf_loan_issue_ef.php?menu=nf"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=nf"))
	insDoc(aux3, gLnk("R", "Statement", "../nf/nf_statement.php?menu=nf"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=nf"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=nf"))*/

//-----------------------------EMI Calculator-----------------------------------------------
 	//aux3 = insFld(aux2, gFld("EMI Calculator", "../general/principal_calculator.php?menu=emi"))
		
//-----------------------------CAR LOAN MODULE -----------------------------------------------
 /*	aux3 = insFld(aux2, gFld("CAR-Loan", "../general/loan_main.php?menu=car"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=car"))
	insDoc(aux3, gLnk("R", "Existing", "../carloan/car_loan_balance_ef.php?menu=car"))
        insDoc(aux3, gLnk("R", "Issue", "../carloan/car_loan_issue_ef.php?menu=car"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=car"))
	insDoc(aux3, gLnk("R", "Statement", "../carloan/car_statement.php?menu=car"))
	//insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=car"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=car"))
  



//-----------------------------EDUCATION LOAN MODULE -----------------------------------------------
 	//aux3 = insFld(aux2, gFld("EDUCATION-Loan", "../educationloan/main_menu.php?menu=edu"))
	aux3 = insFld(aux2, gFld("EDUCATION-Loan", "../main/nextaccount.php?menu=edu"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=edu"))
        insDoc(aux3, gLnk("R", "Issue", "../educationloan/eduloan_ledger_ef.php?menu=edu"))
	insDoc(aux3, gLnk("R", "Existing", "../educationloan/edu_loan_balance_ef.php?menu=edu"))
        //insDoc(aux3, gLnk("R", "Repay", "../mtloan/mtl_loan_repayment.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=edu"))
	insDoc(aux3, gLnk("R", "Statement", "../educationloan/eduloan_statement.php?menu=edu"))
	insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=edu"))

	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=edu"))
    //  insDoc(aux3, gLnk("R", "Delete all Transactions of A/c", "../report/accno_tran_delete.php?menu=*"))
    //    insDoc(aux3, gLnk("R", "Delete Particulars Transactions", "../report/par_tran_delete.php?menu=*"))

//-----------------------------PERSONAL LOAN MODULE -----------------------------------------------
 	//aux3 = insFld(aux2, gFld("PERSONAL-Loan", "../personalloan/main_menu.php?menu=pcl"))
	aux3 = insFld(aux2, gFld("PERSONAL-Loan", "../main/nextaccount.php?menu=pcl"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=pcl"))
        insDoc(aux3, gLnk("R", "Issue", "../personalloan/personal_loan_ledger_ef.php?menu=pcl"))
	insDoc(aux3, gLnk("R", "Existing", "../personalloan/personal_loan_balance_ef.php?menu=pcl"))
        //insDoc(aux3, gLnk("R", "Repay", "../mtloan/mtl_loan_repayment.php?menu=mt"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=pcl"))
	insDoc(aux3, gLnk("R", "Statement", "../personalloan/mtloan_statement.php?menu=pcl"))
	insDoc(aux3, gLnk("R", "Main", "../general/loan_main.php?menu=pcl"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=pcl"))
    
*/

//--------------------------------------FISARY LOAN----------------------------------------
/*
        aux3 = insFld(aux2, gFld("Fishery-Loan", "../general/loan_main.php?menu=fis"))
	insDoc(aux3, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=fis"))
	insDoc(aux3, gLnk("R", "Existing", "../fisary/fis_loan_balance_ef.php?menu=fis"))
        insDoc(aux3, gLnk("R", "Issue", "../fisary/fis_loan_issue_ef.php?menu=fis"))
	insDoc(aux3, gLnk("R", "Repay", "../general/loan_repay.php?menu=fis"))
	insDoc(aux3, gLnk("R", "Statement", "../fisary/fis_statement.php?menu=fis"))
	insDoc(aux3, gLnk("R", "Report", "../general/loan_report_list.php?menu=fis"))

//------------------------Loan Report Module ........................................... 
aux3 = insFld(aux2, gFld("Loan Report", ""))
       insDoc(aux3, gLnk("R", "Report", "../report/loan_report.php?menu=*"))
*/
//----------------------SHG Module .............................................

aux2 = insFld(foldersTree, gFld("SHG", "../shg/shg_info_view.php?menu=shg"))
        insDoc(aux2, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=shg"))
	insDoc(aux2, gLnk("R", "Loan Balance", "../shg/loan_balance_ef.php?menu=shg"))
        insDoc(aux2, gLnk("R", "Issue", "../shg/loan_ledger_ef.php?menu=shg"))
	insDoc(aux2, gLnk("R", "Repay", "../shg/loan_ledger_efr.php?menu=shg"))
	insDoc(aux2, gLnk("R", "Statement", "../shg/shg_mem_detail.php?menu=shg"))
	//insDoc(aux2, gLnk("R", "Main", "../shg/shg_info_view.php?menu=shg"))
	insDoc(aux2, gLnk("R", "Report", "../shg/shg_report.php?menu=shg"))
//----------------------JLG Module .............................................
//aux2 = insFld(aux1, gFld("SHG", "../main/nextaccount.php?menu=shg"))
aux2 = insFld(foldersTree, gFld("JLG", "../main/nextaccount.php?menu=jlg"))
        insDoc(aux2, gLnk("R", "Next a/c", "../main/nextaccount.php?menu=jlg"))
	insDoc(aux2, gLnk("R", "Loan Balance", "../jlg/jlg_loan_balance_ef.php?menu=jlg"))
        insDoc(aux2, gLnk("R", "Issue", "../jlg/loan_ledger_ef.php?menu=jlg"))
	insDoc(aux2, gLnk("R", "Repay", "../jlg/loan_ledger_efr.php?menu=jlg"))
	insDoc(aux2, gLnk("R", "Statement", "../jlg/jlg_mem_detail.php?menu=jlg"))
	//insDoc(aux2, gLnk("R", "Main", "../general/loan_main.php?menu=jlg"))
	insDoc(aux2, gLnk("R", "Report", "../jlg/shg_report.php?menu=jlg"))

//---------------------------------------Advance----------------------------------------------------  

	aux2 = insFld(foldersTree, gFld("Advance", "../main/myzone.php"))
	insDoc(aux2, gLnk("R","Main", "../adv/main_sr.php"))
	//insDoc(aux2, gLnk("R","Advance", "../adv/tran.php"))
	insDoc(aux2, gLnk("R","GL Master", "../adv/master.php"))

//----------retail menu-----------------
/*	aux1 = insFld(foldersTree, gFld("Retail Shop", "../retail/main_menu.php?menu=rsh"))
	aux2 = insDoc(aux1, gLnk("R", "Master", "../retail/master.php?menu=rsh"))
		insDoc(aux1, gLnk("R", "Opening", "../retail/opening.php?menu=rsh"))
		insDoc(aux1, gLnk("R", "Stock Entry", "../retail/stockIn.php?menu=rsh"))
		insDoc(aux1, gLnk("R", "Transaction", "../retail/transaction.php?menu=rsh"))
		insDoc(aux1, gLnk("R", "Return", "../retail/return.php?menu=rsh"))
		insDoc(aux1, gLnk("R", "Transfer", "../retail/transfer.php?single=true"))
		insDoc(aux1, gLnk("R", "Shortage", "../retail/shortage.php?single=true"))		
		insDoc(aux1, gLnk("R", "Reports", "../retail/report.php?menu=rsh"))
*/
//=====================================voucher====================================
aux1 = insFld(foldersTree, gFld("Voucher", "../main/myzone.php?menu=vou"))
	 insDoc(aux1, gLnk("R", "Receive", "../general/voucher.php?menu=vou&op_v=r"))
      	 insDoc(aux1, gLnk("R", "Payment", "../general/voucher.php?menu=vou&op_v=pa"))
	 insDoc(aux1, gLnk("R", "Journal", "../general/voucher.php?menu=vou&op_v=jv"))
	 insDoc(aux1, gLnk("R", "Sales", "../general/voucher.php?menu=vou&op_v=s"))
	 insDoc(aux1, gLnk("R", "Purchases", "../general/voucher.php?menu=vou&op_v=pu"))
	 insDoc(aux1, gLnk("R", "Show", "../general/voucher_rpt.php?menu=vou"))

	insDoc(aux1, gLnk("R", "Manual", "../manual/voucher_manual.html"))

//--------------------------------------Return--------------------------------------------
aux2 = insFld(foldersTree, gFld("Scroll", "../general/scroll_list.php?menu=gen"))
aux2 = insFld(foldersTree, gFld( "Ledger Create", "../general/ledger_view.php?menu=gen"))


//=======================day book====================
aux1 = insFld(foldersTree, gFld("Cash & Day Book", "../main/myzone.php?menu=gen"))
	insDoc(aux1, gLnk("R", "Day Book", "../fa_reports/gl_ledger_db.php?"))
	insDoc(aux1, gLnk("R", "Cash Book", "../general/general_ledger_details.php?menu=gen&op=c&gl_code=28101"))
	insDoc(aux1, gLnk("R", "Denomination", "../general/denomination.php?"))	
	insDoc(aux1, gLnk("R", "Daily Scroll", "../fa_reports/day_book.php"))
        insDoc(aux1, gLnk("R", "Account Ledgers", "../fa_reports/gl_ledger.php"))
	 //insDoc(aux1, gLnk("R", "General Ledgers", "../fa_reports/gl_all.php"))

/*
//=====================================MINI====================================================

aux1 = insFld(foldersTree, gFld("Mini", "../mini/cust_mini_infmtn.php"))
	insDoc(aux1, gLnk("R", "Customer Land Crop Info", "../mini/cust_land_crop_dtl.php"))
	insDoc(aux1, gLnk("R", "Operator Info", "../mini/operator_info.php"))
	insDoc(aux1, gLnk("R", "Report", "../mini/mini_report.php"))
	insDoc(aux1, gLnk("R", "Electric Bill", "../mini/electric_bill.php"))

*/
//-----------------------------Asset Management----------------------------------------------
aux1 = insFld(foldersTree, gFld("Fixed Assets", "../main/myzone.php?menu=myzone"))
	insDoc(aux1, gLnk("R", "Opening", "../assets/asset_op.php?menu=ast"))
	insDoc(aux1, gLnk("R", "Purchases", "../assets/asset_purchases.php?menu=ast"))
	insDoc(aux1, gLnk("R", "Sales", "../assets/asset_sales.php?menu=ast"))
	//insDoc(aux1, gLnk("R", "Customer", "../customer/customer_account_ef.php?menu=cust&type=Other"))
	//insDoc(aux1, gLnk("R", "Vendor", "../retail/vendor_master.php?menu=rsh"))
	//insDoc(aux1, gLnk("R", "Closing", "#"))
        insDoc(aux1, gLnk("R", "Periodical Dep/App Charging", "../assets/peroid_dep_charging.php?menu=ast"))
        insDoc(aux1, gLnk("R", "Report", "../assets/report1.php?menu=ast"))
        insDoc(aux1, gLnk("R", "Manual", "../retail/dep_app.php"))
//-----------------------------Investment----------------------------------------------

aux1 = insFld(foldersTree, gFld("Investment", "../main/myzone.php?menu=myzone"))
	//insDoc(aux1, gLnk("R", "Share", "../investment/sh_investment.php?menu=inv&op=sh"))
	insDoc(aux1, gLnk("R", "Bank Investment", "../investment/bk_investment.php?menu=inv&op=bk"))
	//insDoc(aux1, gLnk("R", "Statement RD", "../investment/bk_investment_rd.php"))
	insDoc(aux1, gLnk("R", "Investment Report", "../investment/inv_report.php"))
	//insDoc(aux1, gLnk("R", "Test page", "../investment/asst_hdr_ldr.php"))
//-----------------------------------------------------------------------------------------------

      		//insDoc(aux2, gLnk("R", "Group", "../retail/group_master.php?menu=rsh"))	

	//insDoc(aux1, gLnk("R", "Register", "../investment/reg_investment.php?menu=inv"))
	//insDoc(aux1, gLnk("R", "Income on Investments", ""))
//---------------------------Bank books-----------------------------------
aux1 = insFld(foldersTree, gFld("Bank Books", "../main/myzone.php?menu=myzone"))
	insDoc(aux1, gLnk("R", "Bank A/C", "../bankbooks/bank_books_new.php?menu=bb&op=c"))
	insDoc(aux1, gLnk("R", "Report", "../bankbooks/bank_books_report.php"))
	insDoc(aux1, gLnk("R", "Clearing", "../bankbooks/cheque_report.php?menu=bb"))
	//insDoc(aux1, gLnk("R", "Yearly Report", "../bankbooks/bank_books_new.php?menu=bb&op=m"))

//******************************MONTHLY RETURN***********************************************
aux2 = insFld(foldersTree, gFld("Monthly Return", "../main/myzone.php?menu=gen"))
              insDoc(aux2, gLnk("R", "MonthlyReport", "../general/monthly_list.php?menu=gen"))
	// insDoc(aux2, gLnk("R", "Monthly Report Final", "../general/monthly_list_final.html?menu=gen"))
//------------------------------Auditors Report

aux2 = insFld(foldersTree, gFld( "Final Report", "../fa_reports/report.php"))


/*aux1 = insFld(foldersTree, gFld("Auditor's Report", "../main/myzone.php?menu=fin"))
         insDoc(aux1, gLnk("R", "Trial Balance(B4)", "../fa_reports/trial_balance_before.php"))	
	 insDoc(aux1, gLnk("R", "Trial Balance(Adj)", "../fa_reports/trial_balance.php"))
	 insDoc(aux1, gLnk("R", "Cash Cum Trial[Dr]", "../fa_reports/trial_balance_dr.php"))
	 insDoc(aux1, gLnk("R", "Cash Cum Trial[Cr]", "../fa_reports/trial_balance_cr.php"))
	 insDoc(aux1, gLnk("R", "Trading A/C ", "../fa_reports/trading.php"))
         insDoc(aux1, gLnk("R", "Profit & Loss A/C", "../fa_reports/profit_loss.php"))
	 insDoc(aux1, gLnk("R", "Balance Sheet", "../fa_reports/balance_sheet.php"))
	 insDoc(aux1, gLnk("R", "Cash A/C", "../fa_reports/monthly_cash_ac.php"))
	 insDoc(aux1, gLnk("R", "Yearly Cash A/C", "../fa_reports/yearly_cash_ac.php"))
	 //insDoc(aux1, gLnk("R", "Account Ledgers", "../fa_reports/gl_ledger.php"))	
	 //insDoc(aux1, gLnk("R", "Day Book", "../fa_reports/gl_ledger_db.php"))
	 //insDoc(aux1, gLnk("R", "Trial Balance", "../fa_reports/trial_balance.php"))
	 
         insDoc(aux1, gLnk("R", "Potato-NPA Register", "#"))
         insDoc(aux1, gLnk("R", "Aman-NPA Register","#"))
         insDoc(aux1, gLnk("R", "Boro-NPA Register","#"))
         insDoc(aux1, gLnk("R", "Asset clasf.&Provising","#"))
         insDoc(aux1, gLnk("R", "Periodwise overdues", "#"))
         insDoc(aux1, gLnk("R", "Depreciation chart", "#"))*/
//------------------------------Control Register

/* aux2 = insFld(foldersTree, gFld( "Control Register", "../general/c_r_report.php")) */


/*
aux1 = insFld(foldersTree, gFld("Control Register", "../main/myzone.php?menu=fin"))
	 insDoc(aux1, gLnk("R", "Balancing Register", "#"))	
	 insDoc(aux1, gLnk("R", "Membership Register","#"))
	 insDoc(aux1, gLnk("R", "Accounts opened & closed Register", "#"))
	 insDoc(aux1, gLnk("R", "Inoperative Deposit A/c Register ", "#"))
         insDoc(aux1, gLnk("R", "Maturity Register", "#"))
	 insDoc(aux1, gLnk("R", "Insurance Policy Register", "#"))
         insDoc(aux1, gLnk("R", "Borrowing Due date Register","#"))
	 insDoc(aux1, gLnk("R", "Investment Maturity Register", "#"))
         insDoc(aux1, gLnk("R", "Pledged stock Register", "#"))
	 insDoc(aux1, gLnk("R", "Suit Field Register", "#"))
         insDoc(aux1, gLnk("R", "DCB Register", "#"))
	 insDoc(aux1, gLnk("R", "Overdue NPA Register", "#"))
         insDoc(aux1, gLnk("R", "Minutes Book ", "#"))
	 insDoc(aux1, gLnk("R", "Gold stock Register", "#"))

         insDoc(aux1, gLnk("R", "Sundry Debtors", "#"))
	 insDoc(aux1, gLnk("R", "Sundry Creditors", "#"))*/

//------------------------------MIS Register


/*  aux1 = insFld(foldersTree, gFld("MIS Register", "../main/myzone.php?menu=fin")) */
	 


	/* insDoc(aux1, gLnk("R", "Demand List", "../fa_reports/demand_loan_rpt.php"))
	 insDoc(aux1, gLnk("R", "Loan History", "../fa_reports/yearly_loan_rpt.php"))
	 insDoc(aux1, gLnk("R", "Period-wise classification of overdues", "#"))
	 insDoc(aux1, gLnk("R", "Asset classification & Provisioning ", "#"))
         insDoc(aux1, gLnk("R", "Stock Position", "#"))
	 insDoc(aux1, gLnk("R", "Details of Deposits Mobilised", "#"))
         insDoc(aux1, gLnk("R", "Growth in share capital", "#"))
	 insDoc(aux1, gLnk("R", "Progress Report", "#"))
         insDoc(aux1, gLnk("R", "Set of performance indicators", "#"))
	 insDoc(aux1, gLnk("R", "Concise structure of Balance Sheet", "#"))
         insDoc(aux1, gLnk("R", "Financial Ratios", "#"))
	 insDoc(aux1, gLnk("R", "Cash Flow statement", "#"))
         insDoc(aux1, gLnk("R", "ks/LT issued during the year", "#"))
	 insDoc(aux1, gLnk("R", "KCC scheme", "#"))*/
//------------------------------Analysis of Financial Statement
aux1 = insFld(foldersTree, gFld("Analysis of Financial Statement", "../main/myzone.php?menu=myzone"))
		insDoc(aux1, gLnk("R", "Working Capital", "../mis_rpt/al_mis_report.php"))

/*aux1 = insFld(foldersTree, gFld("Analysis of Financial Statement", "../main/myzone.php?menu=fin"))
	 insDoc(aux1, gLnk("R", "Working Fund", "#"))	
	 insDoc(aux1, gLnk("R", "Average Yield", "#"))
	 insDoc(aux1, gLnk("R", "Average Cost", "#"))
	 insDoc(aux1, gLnk("R", "Financial Margin ", "#"))
         insDoc(aux1, gLnk("R", "Transaction cost", "#"))
	 insDoc(aux1, gLnk("R", "Risk cost", "#"))
         insDoc(aux1, gLnk("R", "Net margin", "#"))	
	 insDoc(aux1, gLnk("R", "Net Worth", "#"))
	 insDoc(aux1, gLnk("R", "Capital Adequacy Ratio", "#"))
	 insDoc(aux1, gLnk("R", "Credit Deposit Ratio ", "#"))
         insDoc(aux1, gLnk("R", "Ratio of Total Loans to Total Assets", "#"))
	 insDoc(aux1, gLnk("R", "Ratio of Total Deposits to Total Assets", "#"))
         insDoc(aux1, gLnk("R", "Ratio of operating Expenses to Average Total Assets", "#"))
	 insDoc(aux1, gLnk("R", "Ratio of interest earned to interest paid", "#"))*/

//------------------------------------------------------------------------------------------------------------
aux2 = insFld(foldersTree, gFld( "Coding", "../fa/coding_report.php"))


aux1 = insFld(foldersTree, gFld("Log off", "../main/myzone.php?menu=myzone"))
      		insDoc(aux1, gLnk("T", "Yes Log Off", "../index.php"))





