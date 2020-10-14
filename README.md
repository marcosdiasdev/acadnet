# Acadnet

A Acadnet foi um projeto desenvolvido como parte do meu trabalho de conclusão de curso (TCC) de graduação, entre 2012 e 2013, quando cursei do quarto ao sexto período da minha graduação em Gestão da Tecnologia da Informação. Trata-se de uma rede social com fins acadêmicos, com interface gráfica baseada no saudoso Orkut.

O projeto utiliza jQuery, PHP 5 e MySQL, além das libs `phpmailer` e `timthumb`.

## Executando o projeto

Para executar o projeto, é necessário executar o script de criação da base de dados, presente em `./sql/acadnet.sql`.

As configurações de conexão à base de dados encontram-se no método `conexao()`, na classe `Principal`, em `./class/principal.class.php`.

Se você estiver utilizando uma versão do PHP posterior à 5.6, haverá uma série de incompatibilidades a serem solucionadas, em especial, com a biblioteca `mysql_*`.

## Aviso 🛑

É importante salientar que o projeto não utiliza padrões, possui código de péssima qualidade e não deve ser tomado como exemplo para outros projetos.