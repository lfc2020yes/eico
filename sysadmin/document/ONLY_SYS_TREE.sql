DELETE  
-- select * 
FROM _TREE WHERE NOT 
(
 PARAGRAF LIKE 'sys%' OR PARAGRAF='1.00' OR PARAGRAF='1.'
 OR 
 PARAGRAF LIKE '7%' OR PARAGRAF='3' OR PARAGRAF='4' OR PARAGRAF LIKE '4.2%'
)
/*select * from _TREE where PARAGRAF like 'sys%' or PARAGRAF='1.00' or PARAGRAF='1.' */