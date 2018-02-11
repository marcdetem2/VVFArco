-- CAMBIA TURNO
-- chiamata
SELECT public.f_cambia_turno
(' . $_POST['matricola_new'] . ', ' . $_POST['matricola_old'] . ', ' . $_POST['settimana'] . ', ' . $_POST['anno'] . ');
-- output
boolean (tabella con cella singola???)
-- corpo
UPDATE public.t_calendario
	SET matricola=p_matricola_new
	WHERE settimana=p_settimana AND anno=p_anno
    AND matricola=p_matricola_old;
-- note

--------------------------------------------------------------------------------
-- MOSTRA VIGILI DEL TURNO
-- chiamata
SELECT * FROM public.f_mostra_vigili_turno($settimana,$anno);
-- output
tabella
-- corpo
SELECT gr.descrizione, oc.cognome, oc.nome, oc.matricola, cal.cercapersone
	FROM public.t_calendario AS cal, public.t_organico_corpo AS oc,
    public.t_gradi AS gr
    WHERE gr.id=oc.id_grado AND cal.matricola=oc.matricola
    AND cal.settimana=p_settimana
    AND cal.anno=p_anno
    ORDER BY oc.id_grano, oc.cognome, oc.nome ASC;
-- note
- ordinare risultati per grado, cognome, nome

--------------------------------------------------------------------------------
-- MOSTRA ABILITAZIONI VIGILI DEL TURNO
-- chiamata
SELECT * from public.f_mostra_vigili_turno_abilitazioni($settimana,$anno);
-- output
tabella
-- corpo
SELECT ab.matricola, patenteb, rimorchi, daf, trattore, gru,
	muletto, sgombraneve, piattaforme_aeree, motoseghe,
    patentec, autoscala, dae, saf
	FROM public.t_abilitazioni AS ab, public.t_calendario AS cal,
    	public.t_organico_corpo AS oc
    WHERE ab.matricola=cal.matricola AND cal.matricola=oc.matricola
    AND cal.settimana=p_settimana AND cal.anno=p_anno
    ORDER BY oc.id_grado, oc.cognome, oc.nome ASC
-- note
- ordinare risultati per grado, cognome, nome

--------------------------------------------------------------------------------
-- AGGIONGE VIGILE AL CALENDARIO
-- chiamata
SELECT public.f_aggiungi_vigile_calendario(' . $_POST["settimana"] . ', ' . $_POST["anno"] . ', ' . $_POST["matricola"] . ');
-- output
boolean (tabella con cella singola???)
-- corpo
INSERT INTO public.t_calendario(
	settimana, anno, matricola, cercapersone)
	VALUES (p_settimana, p_anno, p_matricola, p_cercapersone);
-- note
- possibilità di assegnare cercapersone in caso il cercapersone non sia già stato assegnato
    (2 funzioni con diverso numero di parametri oppure uso di DEFAULT per p_cercapersone)

--------------------------------------------------------------------------------
-- AGGIUNGI VIGILE ALL'ORGANICO
-- chiamata
SELECT public.f_aggiungi_vigile('" . $_POST["cognome"] . "','" . $_POST["nome"] . "'," . $_POST["matricola"]
	 . "," . $_POST["grado"] . ", '" . $_POST["assunzione"] . "', '" . $_POST["mansione"]
	  . "', '" . $_POST["cellulare01"] . "', '" . $_POST["cellulare02"] . "', '" . $_POST["casa"] . "');
-- output
boolean (tabella con cella singola???)
-- corpo
INSERT INTO public.t_organico_corpo(
	matricola, cognome, nome, id_grado, tel_cellulare01,
    tel_cellulare02, tel_casa, indirizzo_casa, assunzione, mansione)
	VALUES (p_matricola, p_cognome, p_nome, id_grado, p_tel_cellulare01,
            p_tel_cellulare02, p_tel_casa, p_indirizzo_casa, p_assunzione, p_mansione);
-- note
- aggiungere parametri che mancano
- modificare nome colonne
-

--------------------------------------------------------------------------------
-- FUNZIONE
-- chiamata
-- output
-- corpo
-- note


--------------------------------------------------------------------------------
-- FUNZIONE
-- chiamata
-- output
-- corpo
-- note

SELECT column_name FROM information_schema.columns WHERE table_name ='table';

SELECT DISTINCT td.squadra FROM public.t_turni_default AS td ORDER BY td.squadra ASC;

SELECT public.f_aggiungi_vigile_turni_default(' . $squadra . ', ' . $matricola . ');

SELECT public.f_rimuovi_vigile_turni_default(' . $squadra . ', ' . $matricola . ');


POPULATE FORM FIELDS
Change the value attribute:
<input autocomplete='off' class='loginInput' tabindex='3' type="text"
name="company" id="company" value="MyCo" maxlength='50' size="25">



-- seleziona tutti i valori possibili di un type enum
SELECT unnest(enum_range(NULL::public.abilitazione))



-- aggiunge tuple alla tabella t_login con password cryptata
CREATE EXTENSION pgcrypto;
INSERT into t_login (username, password)
     VALUES ('user',crypt('pass', gen_salt('bf')));
