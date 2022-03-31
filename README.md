# APICadastroCliente

Hoje em dia é primordial criar e consumir API para facilitar e auxiliar nas tarefas do dia a dia. O projeto está baseado na arquitetura MVC, porém não totalmente já que não faz uso de view. Foi utilizado os Design Patters **Strategy** e **Chain of responsibility**. O **strategy** para fazer as instaciação do controller de acordo com a rota e **chain of responsibility** para validar as requisições para API. Foi utilizado o **ORM Doctrine** que fornece serviços de persistência e abstração da camada do banco de dados, pois faz mapeamento relacional de objetos. 


## Configurações Iniciais

Vamos utilizar um virtual Host usando XAMPP no windows, mas abaixo será explicado o passo à passo para configuração do host.


Abaixo a lista de pré-requisitos de utilização da API:

- xampp - [(download)](https://www.apachefriends.org/download.html)
- postman - [(download)](https://www.postman.com/downloads/)
- composer - [(download)](https://getcomposer.org/download/)

### Configurando Virtual Host

1. Vá na busca do Windows e digite: **Bloco de notas**

2. Abra como **Administrador**

3. Logo após acesse o caminho: 
``` 
C:\Windows\System32\drivers\etc\hosts
`````
Nesse arquivo, você encontrará o ip para sua máquina (127.0.0.1) com nome na frente “localhost”. Quando você digitar “localhost” no seu navegador, ele está apontando para sua máquina, então o Apache (Servidor Web) vai apontar para sua pasta.

4. Agora adicione o domínio que você deseja como está no localhost. Eu configurei da seguinte forma:
```
127.0.0.1	local.apicadastrocliente
````
5. Agora é só salvar o arquivo. Porém não é preciso fechar, pois será preciso configurar o apache e utilizaremos **bloco de notas**  para isso.


### Configurando Apache

1. Para configurar o **apache** acesse o caminho:
````
C:\xampp\apache\conf\extra\httpd-vhosts.conf
````
2. É neste arquivo que configuramos os **Virtual Hosts**.
3. Copie o código abaixo e cole no final do arquivo:
````
<VirtualHost *:80>
    ServerName local.apicadastrocliente
    ServerAlias www.local.apicadastrocliente
    DocumentRoot "F:\xampp\htdocs\Projetos\apicadastrocliente\public"
    ErrorLog "logs/local.apicadastrocliente-error.log"
    CustomLog "logs/local.apicadastrocliente-access.log" common
    <Directory "F:\xampp\htdocs\Projetos\apicadastrocliente\public">
        DirectoryIndex index.php index.html index.htm
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost> 
````
Essas são as configurações necessárias para funcionamento da API em sua máquina.

## Download do projeto

1. Você pode realizar um **git clone**:
````
git clone https://github.com/alvescbjr/APICadastroCliente.git
````
2. Ou você pode realizar o download do zip do projeto através do botão code aqui no github.

3. Agora é só realizar as requisições através do **postman**.

## Documentação

- **POST** - save

| URI | http://local.apicadastrocliente/api/clientes |
| ------ | ------ |
| Authorization | Bearer Token |
|Token |eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.CNvBJJ6ebLtFr9xB3mr1iCiiRZBXvpemJRLKTcQvgJ8|
| Content-Type | application/json |

```
{
  "nome": "joão",
  "cpf": "123.123.123-10",
  "data_nascimento": "01/01/1949",
  "telefones": {
    "numero_1": "(11) 2961-2691",
    "numero_2": "(11) 2961-2692"
  }
}
````

- **GET** - findBy

| URI | http://local.apicadastrocliente/api/clientes/1/list |
| ------ | ------ |
| Authorization | Bearer Token |
|Token |eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.CNvBJJ6ebLtFr9xB3mr1iCiiRZBXvpemJRLKTcQvgJ8|
| Content-Type | application/json |

- **GET** - findOneBy

| URI | http://local.apicadastrocliente/api/clientes/1 |
| ------ | ------ |
| Authorization | Bearer Token |
|Token |eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.CNvBJJ6ebLtFr9xB3mr1iCiiRZBXvpemJRLKTcQvgJ8|
| Content-Type | application/json |

- **PUT** - update

| URI | http://local.apicadastrocliente/api/clientes/1 |
| ------ | ------ |
| Authorization | Bearer Token |
|Token |eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.CNvBJJ6ebLtFr9xB3mr1iCiiRZBXvpemJRLKTcQvgJ8|
| Content-Type | application/json |

```
{
  "nome": "joão",
  "cpf": "123.123.123-10",
  "data_nascimento": "01/01/1949",
}
````

- **DELETE** - remove

| URI | http://local.apicadastrocliente/api/clientes/1 |
| ------ | ------ |
| Authorization | Bearer Token |
|Token |eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.CNvBJJ6ebLtFr9xB3mr1iCiiRZBXvpemJRLKTcQvgJ8|
| Content-Type | application/json |
