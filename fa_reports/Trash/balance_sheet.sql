SELECT gl_sub_header_desc,gl_sub_header_code, sum(b.received) as received, sum(b.transfer) as transfer from gl_sub_header_vw as a, ( 
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date>='2010-04-01' AND action_date<='2011-03-31') group by a.gl_mas_code
UNION ALL
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')  and  debit-credit> 0 and action_date>='2010-04-01' AND action_date<='2011-03-31' AND tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) 
GROUP BY a.gl_mas_code
UNION ALL

SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  tran_id IN (select tran_id from mas_gl_tran where action_date>='2010-04-01' AND action_date<='2011-03-31' AND gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) AND a.gl_mas_code NOT IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')  and  debit-credit< 0 and action_date>='2010-04-01' AND action_date<='2011-03-31' 
GROUP BY a.gl_mas_code
) as b where typ='R' and a.gl_mas_code=b.gl_mas_code 
group by gl_sub_header_desc,gl_sub_header_code
ORDER BY gl_sub_header_code
-------------------------------------------------------------------------------------------------------------------------------------------------------------------
SELECT gl_sub_header_desc,gl_sub_header_code, sum(b.payment) as payment, sum(b.transfer) as transfer from gl_sub_header_vw as a,( 
select 'P' as typ,a.gl_mas_code, count(*) as cnt, 0.00 as received, 0.00 as transfer, sum(debit-credit) as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit<0 and action_date>='2010-04-01' AND action_date<='2011-03-31') group by a.gl_mas_code
union all
select 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')  and  credit-debit> 0 and action_date>='2010-04-01' AND action_date<='2011-03-31' AND tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) 
GROUP BY a.gl_mas_code
UNION ALL
SELECT 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(debit-credit) as transfer, 0.00 as Payment from mas_gl_tran as a where  tran_id IN (select tran_id from mas_gl_tran where action_date>='2010-04-01' AND action_date<='2011-03-31' AND gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) AND a.gl_mas_code NOT IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')  and  credit-debit< 0 and action_date>='2010-04-01' AND action_date<='2011-03-31' GROUP BY a.gl_mas_code
) as b where typ='P' and a.gl_mas_code=b.gl_mas_code 
group by gl_sub_header_desc,gl_sub_header_code
ORDER BY gl_sub_header_code
----------------------------
SELECT SUM(transfer) FROM (
select 'P' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')  and  credit-debit> 0 and action_date>='2010-04-01' AND action_date<='2011-03-31' AND tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) 
GROUP BY a.gl_mas_code
) AS foo

SELECT SUM(transfer) FROM (
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  tran_id IN (select tran_id from mas_gl_tran where action_date>='2010-04-01' AND action_date<='2011-03-31' AND gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) AND a.gl_mas_code NOT IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')  and  debit-credit< 0 and action_date>='2010-04-01' AND action_date<='2011-03-31' 
GROUP BY a.gl_mas_code
) AS foo
/*select initcap(a.gl_mas_desc) AS gl_mas_desc, b.gl_mas_code, sum(b.cnt) as cnt, sum(b.received) as received, sum(b.transfer) as transfer from gl_master as a, ( 
select 'R' as typ, a.gl_mas_code, count(*) as cnt, sum(credit-debit) as received, 0.00 as transfer, 0.00 as Payment from mas_gl_tran as a where a.gl_mas_code not  like '28101' and tran_id in (select tran_id from mas_gl_tran where gl_mas_code like '28101' and debit-credit>0 and action_date>='2010-04-01' AND action_date<='2011-03-31') group by a.gl_mas_code
union all
SELECT 'R' as typ, a.gl_mas_code, count(*) as cnt, 0.00 as received, sum(credit-debit) as transfer, 0.00 as Payment from mas_gl_tran as a where  a.gl_mas_code not  like '28101' and  debit-credit<0 and action_date>='2010-04-01' AND action_date<='2011-03-31' AND tran_id IN (select tran_id from mas_gl_tran where gl_mas_code IN (SELECT gl_mas_code FROM gl_sub_header_vw WHERE  gl_sub_header_code IN ('28100','28200') AND gl_mas_code NOT LIKE '28101')) 
GROUP BY a.gl_mas_code
) as b where typ='R' and a.gl_mas_code=b.gl_mas_code group by b.gl_mas_code, a.gl_mas_desc ORDER BY b.gl_mas_code*/
