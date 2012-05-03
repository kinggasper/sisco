alter table `contrato` Add Column cuotas INT(11);

update `frecuencia` set frecuencia= 1 where id=1;
update `frecuencia` set frecuencia= 2 where id=4;
update `frecuencia` set frecuencia= 3 where id=2;
update `frecuencia` set frecuencia= 4 where id=2;
