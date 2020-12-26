SELECT `a`.`s_id`,`a`.`score` FROM `score` as `a` left join `score` as `b` on`a`.`s_id` = `b`.`s_id`


SELECT `a`.`s_id`,`a`.`score` FROM `score` as `a` right join `score` as `b` on`a`.`s_id` = `b`.`s_id`


SELECT avg(`score`) as `avg_score` FROM `score`

32.833333333333336

SELECT sum(`score`)/count(`score`) as `avg_score` FROM `score`

32.833333333333336



SELECT avg(`score`) as `avg_score` FROM `score` having `avg_score` >20

41.166666666666664

41.166666666666664


SELECT `s_id`,avg(`score`) as `avg_score` FROM `score` group by `s_id` having `s_id` >1

SELECT CASE WHEN 1=1 THEN "SASI" ELSE "KUMARAN" END as `RESULT` FROM DUAL

SELECT CASE WHEN NULL = NULL THEN "SASI" ELSE "KUMARAN" END as `RESULT` FROM DUAL

SELECT CASE WHEN null=null THEN "SASI" ELSE "KUMARAN" END as `RESULT` FROM DUAL

SELECT CASE WHEN `null`=`null` THEN "SASI" ELSE "KUMARAN" END as `RESULT` FROM DUAL