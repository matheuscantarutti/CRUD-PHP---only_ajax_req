create database rbm_test;

use rbm_test;

create table clientes(
	id int primary key not null auto_increment,
    nome varchar(255) not null,
    email varchar(255) not null,
    cpf varchar(255) not null
);

create table produtos(
	id int primary key not null auto_increment,
    nome varchar(255) not null,
    preco decimal(15,2) not null,
    descricao varchar(255) not null,
    quantidade int not null
);

create table vendas(
	id int primary key not null auto_increment,
    data_venda datetime not null,
    preco decimal(15,2) not null,
    quantidade int not null,
    id_cliente int not null
);

create table produto_venda(
	id int primary key not null auto_increment,
    id_venda int not null,
    id_produto int not null,
    preco decimal(15,2) not null,
    quantidade int not null
);

select * from clientes;
select * from produtos;
select * from vendas;





