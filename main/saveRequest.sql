BEGIN
	DECLARE newnumber,newidrequest VARCHAR(6);
	DECLARE countrequest INT;
		SELECT COUNT(id_request) FROM m_request INTO countrequest;
		IF(countrequest = 0 ) THEN
			SET newnumber = '1';
		ELSE
			SELECT TRIM(CAST((CAST(SUBSTR(id_request,3,6) AS UNSIGNED)+1) AS CHAR(4)))    
			FROM m_request 
			ORDER BY id_request DESC LIMIT 1 INTO newnumber;
		END IF; 
		IF (LENGTH(newnumber) = 1) THEN
			SET newidrequest=CONCAT('RQ000',newnumber);
		ELSE
			IF (LENGTH(newnumber) = 2) THEN
				SET newidrequest=CONCAT('RQ00',newnumber);
			ELSE
				IF (LENGTH(newnumber) = 3) THEN
					SET newidrequest=CONCAT('RQ0',newnumber);
				ELSE
					SET newidrequest=CONCAT('RQ',newnumber);
				END IF ;
			END IF ;
		END IF ;
		 INSERT INTO m_request(id_request,id_item    ,quantity    ,buying_price    ,Total_Amount    ,delivery_location    ,block_address    ,datecreated)
		 	          VALUES(newidrequest,var_id_item,var_quantity,var_buying_price,var_total_amount,var_delivery_location,var_block_address,now());
		 select newidrequest as id_request;
    END