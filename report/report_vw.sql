CREATE or replace VIEW report_vw AS
SELECT deposit_detail_view.tran_id, deposit_detail_view.action_date,
deposit_detail_view.account_no, deposit_detail_view.type, deposit_detail_view.gl_mas_code, deposit_detail_view.qty, deposit_detail_view.amount, deposit_detail_view.dr_cr, deposit_detail_view.particulars, deposit_detail_view.operator_code, deposit_detail_view.entry_time FROM deposit_detail_view
UNION ALL
SELECT share_detail_view.tran_id, share_detail_view .action_date, share_detail_view.account_no, share_detail_view.type, share_detail_view.gl_mas_code, share_detail_view.qty, share_detail_view.amount, share_detail_view.dr_cr, share_detail_view.particulars, share_detail_view.operator_code, share_detail_view.entry_time FROM share_detail_view;       










