create or replace view mas_gl_tran as  SELECT a.tran_id, a."type", a.action_date, b.gl_mas_code, b.account_no, b.amount AS debit, 0.00 AS credit, b.particulars    FROM gl_ledger_hrd a, gl_ledger_dtl b   WHERE a.tran_id::text = b.tran_id::text AND b.dr_cr = 'Dr'::bpchar UNION ALL  SELECT a.tran_id, a."type", a.action_date, b.gl_mas_code, b.account_no, 0.00 AS debit, b.amount AS credit, b.particulars FROM gl_ledger_hrd a, gl_ledger_dtl b   WHERE a.tran_id::text = b.tran_id::text AND b.dr_cr = 'Cr'::bpchar;

create view gl_master_vw as  select gl_mas_code, gl_mas_desc, gl_sub_header_code, 'L' as bs_pl from gl_master where gl_mas_code between '10000' and '19999' union all select gl_mas_code, gl_mas_desc, gl_sub_header_code, 'A' as bs_pl from gl_master where gl_mas_code between '20000' and '29999' union all select gl_mas_code, gl_mas_desc, gl_sub_header_code, 'I' as bs_pl from gl_master where gl_mas_code between '30000' and '59999' union all select gl_mas_code, gl_mas_desc, gl_sub_header_code, 'E' as bs_pl from gl_master where gl_mas_code between '60000' and '99999'


create or replace function GL_ledger_rep(date, date) returns setof mas_gl_ledg_rep as $_$ select ln_seq, tran_id, action_date, gl_mas_code, account_no, gl_mas_desc, particulars, debit, credit from (select '0' as ln_seq, 'O' as tran_id, $1 as action_date, a.gl_mas_code,'  ' as account_no, b.gl_mas_desc, 'Opening Balace' as particulars, sum(debit-credit) as debit, 0.00 as credit from mas_gl_tran as a,  gl_master as b where a.gl_mas_code= b.gl_mas_code and a.action_date < $1 group by a.gl_mas_code, b.gl_mas_desc having sum(debit-credit)> 0 union all select '0' as ln_seq,   'O', $1, a.gl_mas_code, '  ' as account_no, b.gl_mas_desc, 'Opening Balance   ' as particulars, 0.00 as debit, sum(credit-debit) as credit from mas_gl_tran as a,  gl_master as b where a.gl_mas_code= b.gl_mas_code  and a.action_date < $1 group by a.gl_mas_code, b.gl_mas_desc having sum(debit-credit)<= 0 union all select '1' as ln_seq, a.tran_id, a.action_date, a.gl_mas_code, account_no, b.gl_mas_desc, a.particulars, debit as debit, credit as credit from mas_gl_tran as a,  gl_master as b where a.gl_mas_code= b.gl_mas_code and action_date between $1 and $2) as a order by gl_mas_code, action_date, ln_seq; $_$ LANGUAGE sql;

create table mas_gl_ledg_rep(ln_seq character(3), tran_id character varying(15),action_date date, gl_mas_code character varying(15), account_no character varying(15), gl_mas_desc character varying(160), particulars character varying(60), debit numeric(15,2), credit numeric(15,2));

CREATE FUNCTION getcrop(character varying) RETURNS character varying
    AS $_$
DECLARE 
loan_sl alias for $1;
crop varchar(5);
BEGIN 
SELECT crop_id INTO crop FROM loan_ledger_hrd WHERE loan_serial_no=loan_sl;
RETURN crop;
END;
$_$
    LANGUAGE plpgsql;


CREATE VIEW GL_MASTER_HEADER_VW AS select BS_PL, gl_master_VW.gl_sub_header_code, gl_header.gl_header_desc, gl_master_VW.gl_mas_code, gl_master_VW.Gl_mas_desc from gl_master_VW LEFT OUTER JOIN gl_header on(gl_master_VW.gl_sub_header_code = gl_header.gl_header_code)

select a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master_vw as b where a.gl_mas_code= b.gl_mas_code and bs_pl='L' group by a.gl_mas_code, b.gl_mas_desc order by a.gl_mas_code


select B.GL_HEADER_DESC, a.gl_mas_code, b.gl_mas_desc, sum(debit) as debit, sum(credit) as credit, sum(debit-credit) as bal from mas_gl_tran as a , gl_master_hEADER_vw as b where a.gl_mas_code= b.gl_mas_code and bs_pl='L' group by a.gl_mas_code, b.gl_mas_desc,B.GL_HEADER_DESC order by a.gl_mas_code
