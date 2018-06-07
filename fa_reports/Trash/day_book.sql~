SELECT INitcap(a.gl_mas_desc) as gl_mas_desc, b.gl_mas_code, SUM(b.cnt) as cnt, SUM(b.received) as received, SUM(b.transfer) as transfer FROM gl_master as a, 
( 
SELECT 'R' as typ, a.gl_mas_code, COUNT(*) as cnt, SUM(credit-debit) as received, 0.00 as transfer, 0.00 as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code NOT LIKE'28101' AND tran_id IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101' AND debit-credit>0 AND action_date='2010-10-11') GROUP BY a.gl_mas_code 
UNION ALL 
SELECT 'P' as typ,a.gl_mas_code, COUNT(*) as cnt, 0.00 as received, 0.00 as transfer, SUM(debit-credit) as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code NOT LIKE'28101' AND tran_id IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101' AND debit-credit<0 AND action_date='2010-10-11') GROUP BY a.gl_mas_code 
UNION 
ALL SELECT 'R' as typ, a.gl_mas_code, COUNT(*) as cnt, 0.00 as received, SUM(credit-debit) as transfer, 0.00 as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code NOT LIKE'28101' AND debit-credit<0 AND action_date='2010-10-11' AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101' AND action_date='2010-10-11') GROUP BY a.gl_mas_code 
UNION ALL
SELECT 'P' as typ, a.gl_mas_code, COUNT(*) as cnt, 0.00 as received, SUM(credit-debit) as transfer, 0.00 as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code NOT LIKE'28101' AND debit-credit<0 AND action_date='2010-10-11' AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101' AND action_date='2010-10-11') GROUP BY a.gl_mas_code 
) as b WHERE typ='R' AND a.gl_mas_code=b.gl_mas_code GROUP BY b.gl_mas_code, a.gl_mas_desc

-------------------------------------------------------------------------------------------------
SELECT INitcap(a.gl_mas_desc) as gl_mas_desc, b.gl_mas_code, SUM(b.cnt) as cnt, SUM(b.payment) as payment, SUM(b.transfer) as transfer FROM gl_master as a, ( 
SELECT 'R' as typ, a.gl_mas_code, COUNT(*) as cnt, SUM(credit-debit) as received, 0.00 as transfer, 0.00 as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code NOT LIKE'28101' AND tran_id IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101' AND debit-credit>0 AND action_date='2010-10-11') GROUP BY a.gl_mas_code 
UNION ALL 
SELECT 'P' as typ,a.gl_mas_code, COUNT(*) as cnt, 0.00 as received, 0.00 as transfer, SUM(debit-credit) as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code NOT LIKE'28101' AND tran_id IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101' AND debit-credit<0 AND action_date='2010-10-11') GROUP BY a.gl_mas_code 
UNION ALL
SELECT 'P' as typ, a.gl_mas_code, COUNT(*) as cnt, 0.00 as received, SUM(debit-credit) as transfer, 0.00 as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code <> '28101' AND action_date='2010-10-11' AND debit-credit>0 AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101') GROUP BY a.gl_mas_code 
 
UNION ALL 
SELECT 'R' as typ, a.gl_mas_code, COUNT(*) as cnt, 0.00 as received, SUM(debit-credit) as transfer, 0.00 as Payment FROM mas_gl_tran as a WHERE a.gl_mas_code <> '28101' AND action_date='2010-10-11' AND debit-credit>0 AND tran_id NOT IN (SELECT tran_id FROM mas_gl_tran WHERE gl_mas_code LIKE'28101') GROUP BY a.gl_mas_code 

) as b WHERE typ='P' AND a.gl_mas_code=b.gl_mas_code GROUP BY b.gl_mas_code, a.gl_mas_desc
