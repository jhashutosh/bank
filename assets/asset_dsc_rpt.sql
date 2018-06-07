CREATE or replace FUNCTION asset_dsc_rpt(character varying, refcursor) RETURNS refcursor
    LANGUAGE plpgsql
    AS $_$

DECLARE

	ast_ty alias for $1;
	rfcr alias for $2;
	
	ast_typ character varying;
	
BEGIN
	
	select into ast_typ lower(ast_ty);
	
	open rfcr for (select row_number() over() srl, * from ( select initcap(asset_desc), count(asset_desc) from asset_master where gl_code=(select gl_mas_code from gl_master where gl_mas_desc=ast_typ) and current_value>0 group by 1) z) ;
	 
	RETURN rfcr;
	
END;

$_$;

ALTER FUNCTION public.asset_dsc_rpt(character varying, refcursor) OWNER TO bank;


