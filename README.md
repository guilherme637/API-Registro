    API Registro de Contas
<hr>
Essa API tem o intuito de mostrar meus conhecimentos em desenvolvimento de API's e praticar os conhecimentos que venho 
adquirindo em meus estudos.
<hr>

    Requisitos
    
    º PHP 7.4* ;
    º Composer ;
    º Extensões PDO.

<hr>

A conexão padrão esta para SQLite, mas você pode escolher qualquer conexão no arquivo `.env` e descomentandos as linhas. para descomentar basta remover `#`.

 DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
#DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?
#DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name


    Executar na linha de comando
    
    º composer install //instala todas dependências que o projeto precisa
    ° php bin/console doctrine:database:create // cria um o banco de dados de acordo com o driver
    ° php bin/console doctrine:migrations:migrate // executa o SQL para criar as tabelas
    ° php bin/console doctrine:fixture:load // irá criar o usuário e tipos de conta
    º php -S localhost:8080 -t public // esse comando ira subir um servidor local para acessar as rotas
    

<hr>

Verbos HTTP's utilizados
 
 - GET
 - POST
 - PUT
 - DELETE
<hr>

A rotas podem ser encontradas acessando `src/Controller/ContaController.php` nesse controle é possível encontrar
todas a rotas que estão sendo chamadas. Assim que é que entrar em `ContaController.php`, irá ver que o construtor recebe
por injeção de dependência algumas classes e interfaces. Foi criado o arquivo de `ResponseJsonFactory`
para retorna o uma response um pouco mais detalhada, mas caso queira usar a classe `JsonResponse` não tem problema, mas 
irá precisar fazer alterações nas responses das outras rotas.

<hr>

TODAS AS ROTAS PRECISÃO DE ATENTICAÇÃO PARA SER ACESSADAS. Para fazer a autenticação basta acessar

`/login` e informar os seguintes campos no corpo da requisição

    {
        "username" : "guilherme"
        "senha" : "gui123"
    }

Assim que enviar a requisição será retornado um token, ele precisa ser enviado em todas as requisições.
Para enviar o token, basta enviar ele no cabeçalho da requisição.

Ainda não foi implemetado a rota para criar novos usuários, então será necessário acessar com esse informado acima.

<br>

<hr>


    Rotas de acesso
<br>

**GET**

Essa rota ira retornar todas as contas que foram criadas. Assim que acessada ele irá chamar o método index,
nesse metódo é possível ver que a nossa classe `ContaController.php`, recebe no construtor outra classe chamada `App\Service\ExtratorRequest.php` 
ela permite fazermos consultas mais específicas. Exemplos de consultas <br>

 -  **Ordernar**  `/contas?sort['campo']=ASC | /contas?sort['campo']=DESC | ex.: /contas?sort['id']=ASC` <br>
   

 - **Filtrar**   `/contas?campo=nomeDaConta | ex.: /contas?id=1`
   

 - **ItensPorPagina e Páginas**  `/contas?itens=2&page=1`
   
Por padrão se não for informando a quantidade de itens por pagianas, sera mostrado automaticamente 10 itens por paginas.


    | GET |     /contas  status:200
    

<br>
<hr>

**POST**

Essa rota vai ser usada para criar uma nova  Conta. Para criar uma nova Conta é necessário enviar os seguintes campos:


    {
        "nome" : "string",
        "valor" : float,
        "data" : "date",
        "tipo" : 1
    }

Para escolher qual tipo de conta basta colocar o id dos tipos de contas

    id | Tipos
    _____________
    1  | Agua
    _____________
    2  | Luz
    _____________
    3  | Telefone
    _____________
    4  | Internet

Para criar uma conta é necessário informar o tipo dela.


    | POST | /contas status:201
<br>
<hr>

**GET**

Essa rota retorna uma conta específica, basta passar o id no parâmetro {id}. 

    | GET |  /conta/{id} status:202

<br>
<hr>

**PUT**

Essa rota irá atualizar, basta informar o número do id no parâmetro {id} os seguintes campos:

    {
        "nome" : "string",
        "valor" : float,
        "data" : "date",
        "tipo" : 1
    }

Apenas essas informações irão atualizar.


    | PUT |  /conta/{id}/update status:204

<br>
<hr>

**DELETE**

Essa rota irá remover uma conta permanentemente, basta informar o número do id no parâmetro {id}.

    | DELETE |  /conta/{id}/delete status:204
<br>
<hr>

**GET**

Essa rota retorna os tipos de contas e todas a consta que estão associadas aos grupos.

    | GET | /tipo/conta/{grupoId} status:200

<hr>

