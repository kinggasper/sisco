ALTER TABLE lote 
    ADD empresa_id INT NOT NULL ,
    ADD tipo_lote_id INT NOT NULL;
ALTER TABLE lote ADD INDEX ( empresa_id );
ALTER TABLE lote ADD INDEX ( tipo_lote_id );

CREATE TABLE IF NOT EXISTS tipo_lote (
    id int(11) NOT NULL AUTO_INCREMENT,
    nombre varchar(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE lote ADD FOREIGN KEY ( empresa_id ) 
    REFERENCES sisco.empresa (id) ON DELETE RESTRICT ON UPDATE RESTRICT ;
ALTER TABLE lote ADD FOREIGN KEY ( tipo_lote_id ) 
    REFERENCES sisco.tipo_lote (id) ON DELETE RESTRICT ON UPDATE RESTRICT ;