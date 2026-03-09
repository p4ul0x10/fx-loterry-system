BEGIN
        DECLARE id_users INTEGER;
        DECLARE total_amount INTEGER;
        DECLARE lt_session INTEGER;
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION BEGIN END;
    
        SET count_user = 0;
        SET lt_session = (SELECT lt_session FROM info WHERE id = 1);
        SET id_users = (SELECT user_per_session FROM info WHERE id > 0);
        SET total_amount = (SELECT sum(valor)valor FROM loterry_tkt_buyed WHERE current_session = lt_session);
        
        DECLARE usersby2 INTERGER;
        SET usersby2 = id_users / 2; #users for win
     
        DECLARE cs INTEGER;
        SET cs = (SELECT lt_session FROM info WHERE id='1');
     
        DECLARE total_tkt_session INTEGER;
        SET total_tkt_session = (SELECT SUM(value)value FROM loterry_tkt_buyed WHERE current_session=cs);
        
        DECLARE paid_per_session;
        SET paid_per_session = (total_tkt_session / 100) * 80; #80 % betwen total amount
        DECLARE dataa SELECT CURDATE;
      
        IF usersby2 >= 1 THEN #total users valid for win  
        
          IF usersby2 = 1 THEN
            
            #start close session and add sets on tables
            UPDATE rel_lt_dep SET status = 1 WHERE id > 0; #status 1 = session ended
            
            DECLARE last_session INTEGER;
            DECLARE session_round INTEGER;
            
            SET last_session = (SELECT id FROM loterry_session WHERE id > 0 ORDER BY id DESC LIMIT 1);
            SET session_round = last_session;
            
            INSERT INTO loterry_session (loterry_session,total_investors,total_tickets,total_winners,total_paid,data) VALUES (session_round,id_users,total_tkt_session,usersby2,paid_per_session,dataa);
            UPDATE info SET lt_session = session_round+1 WHERE id = 1; #add new session round count 
      #end
            
            #start add reward per session
            DECLARE user_win INTEGER;
            DECLARE last_id INTEGER;
            DECLARE user_info_id INTEGER;
            DECLARE user_info_nick INTEGER;
            
            SET user_win =  SELECT ROUND(FLOOR(0 + (RAND() * 2)));
            SET last_id = (SELECT id_user FROM loterry_tkt_buyed WHERE id > 0 ORDER BY id DESC LIMIT 1);
           
            DECLARE add_num INTEGER;
            SET add_num = last_id + user_win;
            SET user_info_id = (SELECT id FROM usuarios WHERE id = add_num);
            SET user_info_nick = (SELECT f_nome FROM usuarios WHERE id = add_num);
            
            INSERT INTO loterry_winners (id_user,pos,nick,total_ticket,total_earn,parcial,data,status,session_id) VALUES (add_num,1,user_info_nick,user_info_tkt,paid_per_session,'100%',dataa,'1',lt_session);
            #end add reward per session
            
          END IF;
            
          IF usersby2 = 2 THEN
           
            UPDATE rel_lt_dep SET status = 1 WHERE id > 0; #status 1 = session ended
            
            DECLARE last_session INTEGER;
            DECLARE session_round INTEGER;
            
            SET last_session = (SELECT id FROM loterry_session WHERE id > 0 ORDER BY id DESC LIMIT 1);
            SET session_round = last_session;
            
            INSERT INTO loterry_session (loterry_session,total_investors,total_tickets,total_winners,total_paid,data) VALUES (session_round,id_users,total_tkt_session,usersby2,paid_per_session,dataa);
            UPDATE info SET lt_session = session_round+1 WHERE id = 1; #add new session round count 
            
            #start add reward per session
            DECLARE user_win INTEGER;
            DECLARE last_id INTEGER;
            DECLARE user_info_id INTEGER;
            DECLARE user_info_nick INTEGER;
            
            SET user_win =  SELECT ROUND(FLOOR(0 + (RAND() * 2)));
            SET last_id = (SELECT id_user FROM loterry_tkt_buyed WHERE current_session BETWEEN lt_session AND lt_session);
           
            DECLARE add_num INTEGER;
            SET add_num = last_id + user_win;
            SET user_info_id = (SELECT id FROM usuarios WHERE id = add_num);
            SET user_info_nick = (SELECT f_nome FROM usuarios WHERE id = add_num);
            
            INSERT INTO loterry_winners (id_user,pos,nick,total_ticket,total_earn,parcial,data,status,session_id) VALUES (add_num,1,user_info_nick,user_info_tkt,paid_per_session,'100%',dataa,'1',lt_session);
            #end add reward per session
            
          END IF;
            
          IF id_users = 5 THEN
          
            UPDATE rel_lt_dep SET status = 1 WHERE status = ''; #status 1 = session ended
            
            DECLARE last_session INTEGER;
            DECLARE session_round INTEGER;
            
            SET last_session = (SELECT id FROM loterry_session WHERE id > 0 ORDER BY id DESC LIMIT 1);
            SET session_round = last_session;
            SET usersby2 = 2;
            INSERT INTO loterry_session (loterry_session,total_investors,total_tickets,total_winners,total_paid,data) VALUES (session_round,id_users,total_tkt_session,usersby2,paid_per_session,dataa);
            UPDATE info SET lt_session = session_round+1 WHERE id = 1; #add new session round count 
            
          END IF;
          
          IF id_users > 5 THEN
            
          END IF;
            
        END IF;
        /*IF v = 1 THEN
        UPDATE info SET id = 2 WHERE id = 1;
        END IF;*/
    END