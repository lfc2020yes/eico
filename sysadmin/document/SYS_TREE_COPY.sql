insert into _TREE
(
select * from _TREE_interstroi where PARENT='sys' and PARAGRAF like 'sys.tree.%'
)