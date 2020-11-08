# Projeto Voxus Locations - Versão 1.0

[![Voxus - Mídia  programática para e-commerce}][i-Voxus]][l-Voxus]

---

**Bases** | **Versão** | **Acesso**
--------------- | :---: | :---:
Desenvolvimento | 1.0   | [link][l-Desenvolvimento]
Homologação     | 1.0   | [link][l-Homologacao]
Produção        | 1.0   | [link][l-Producao]

---

## O que este repositório contém

1. Controle de permissão de usuários ACL.
2. Autenticação com [JWT][l-JWT].
3. Página Home com mapa de Localização de Clientes usando [Mapbox][l-Mapbox] e [Redis][l-Redis].
4. [Swagger][l-Swagger] API REST.
5. Testes Unitários.
6. [Docker][l-Docker].

---

## Qual o objetivo deste repositório

1. Processo seletivo para a empresa [Voxus - Mídia  programática para e-commerce][l-Voxus].
2. Criar uma API para vincular usuários a sua localização via coordenadas de latitude e longitude
3. Executar consultas avançadas em uma query.

---

## O que é necessário para configurar

1. PHP >= 7.2 com requisitos de extensão, conforme descrito na documentação do [Lumen][l-Lumen].
3. [Composer][l-Composer] em uma Versão estável.
4. Qualquer banco de dados de sua escolha, eu usei o MySQL.

---

## Como instalar

- Caso queira usar o docker siga as [instruções][l-Doc-Docker]

```shell script
# Instalar todos os pacotes necessários para executar o projeto
> composer install

** Caso tenha falha de memória do php local, use: **
> COMPOSER_MEMORY_LIMIT=-1 composer install

# Crie o arquivo .env e defina o seu APP_TIMEZONE e banco de dados.
> cp .env.example .env

# Gerar app secret
> php artisan key:generate

# Gerar jwt secret
> php artisan jwt:secret

# Criar as tabelas necessárias no seu banco de dados
# Nota: Lembre-se de criar o banco de dados antes de executar este comando!
> php artisan migrate

# Alimentar nosso banco de dados com dados necessários
> php artisan db:seed

# Recriar os dados de nosso banco de dados
> php artisan migrate:fresh --seed
```

---

## Qual o modelo do diagrama

![Diagrama}][i-Diagrama]

---

## Importar Endpoits da API para o [Insomia][l-Insomia]
[![Importar Insomnia}][i-Insomia-Run]][l-Insomia-Import]

![Insomia][i-Insomia]

---

## Como executar o projeto

```shell script
# Você pode executá-lo no localhost ou pode configurar um virtualhost local
# O servidor fica a sua escolha entre nginx ou apache
# Particularmente prefiro nginx com virtualhost de domínio local. 
# Exemplo: http://voxus.local
# Nota: Informe a URL no projeto importado do Insomia para testar os endpoits. 
> php artisan serve
```

---

## Como gerar/acessar a documentação do [Swagger][l-Swagger-Doc]

```shell script
# Nota: O comando abaixo irá gerar a documentação da API conforme as anotações no código PHP. 
> php artisan swagger-lume:generate

# Para acessar a documentação da API acesse a url abaixo. 
> /api/documentation
```

![Swagger][i-Swagger]

---

## Como posso ver as rotas da API

```shell script
# Lista todas as rotas definidas no projeto 
> php artisan route:list
```

---

## Como executo os testes unitários

```shell script 
> php vendor/bin/phpunit

ou

> composer test
```

---

### Endpoits de consultas de localizações de usuários cadastrados

```
# Importante: O final da url deve conter os parâmetros api/v1.
# Exemplo: http://voxus.local/api/v1

# Exibir todas as localizações.
> GET /api/v1/locations

# Exibir todos, com usuário.
> GET /api/v1/sistemas?include=users

# Filtrar por latitude, com usuário
> GET /api/v1/sistemas?include=users&filter=[latitude]=-86.803792

# Filtrar por latitude e longitude, com usuário
> GET /api/v1/sistemas?include=users&filter=[latitude]=-86.803792&filter=[longitude]=168.04892

# Filtrar por ip
> GET /api/v1/sistemas?filter[ip]=209.12.81.86

# Filtrar por cidade e estado
> GET /api/v1/sistemas?filter=[cidade]=cuiaba&filter=[estado]=mt

# Filtrar por nome de usuário
> GET /api/v1/sistemas?include=users&filter=[users.name]=admin

# Filtrar por e-mail de usuário
> GET /api/v1/sistemas?include=users&filter=[users.email]=admin@admin.com

```

### Endpoit para listar as localizações de um usuário(user_id)

```
> GET /api/v1/locations/user/20
```

### Endpoit para cadastrar uma nova localização para um usuário

```
> POST /api/v1/locations/user
```

### Endpoits de usuários do sistema

```
# Listar todos usuários cadastrados
> /api/v1/users

# Exibir dados do usuário, perfis e permissões por ID
> /api/v1/users/2

1. Perfil - Super Administrador
> Login: super@super.com 
> Senha: super

2. Perfil - Administrador
> Login: admin@admin.com
> Senha: admin

3. Perfil - Técnico
> Login: tecnico@tecnico.com
> Senha: tecnico

4. 50 usuários ficticios com o perfil técnico 
> Senha Padrão: 123456

```

### Endpoit de Login

```
> /api/v1/auth/login
```

---

Se o parâmetro "remember" for enviado como "true", o token JWT irá expirar em 1 semana, caso contrário 1 hora.
Este tempo pode se definido no arquivo .env:
JWT_TTL e JWT_TTL_REMEMBER_ME

```json
{
	"email": "super@super.com",
	"password": "super",
	"remember": true
}

```

[i-Voxus]: doc/img/logo.svg "Voxus - Mídia  programática para e-commerce"
[i-Diagrama]: doc/img/diagrama.png "Diagrama"
[i-Insomia]: doc/img/insomia.png "Insomia"
[i-Insomia-Run]: https://insomnia.rest/images/run.svg "Importar Insomia"
[i-Swagger]: doc/img/swagger.png "Swagger"

[l-Voxus]: https://www.voxus.com.br
[l-Doc-Docker]: docker/README.md
[l-Lumen]: https://lumen.laravel.com/docs/6.x#server-requirements
[l-Insomia]: https://insomnia.rest/download
[l-Insomia-Import]: https://insomnia.rest/run/?label=Voxus%20API&uri=https%3A%2F%2Fraw.githubusercontent.com%2Fjotapepinheiro%2Fvoxus%2Fmain%2Fdoc%2Farquivos%2FInsomnia_export.json
[l-Composer]: https://getcomposer.org
[l-Mapbox]: https://www.mapbox.com
[l-Redis]: https://redis.io
[l-Swagger]: https://swagger.io
[l-JWT]: https://jwt.io
[l-Docker]: https://www.docker.com

[l-Swagger-Doc]: http://voxus.local/api/documentation
[l-Desenvolvimento]: http://voxus.local
[l-Homologacao]: http://voxus.local
[l-Producao]: http://voxus.local
