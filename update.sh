#!/bin/bash
#-----
# Este arquivo é executado toda vez que o docker é iniciado ou também pode ser
# executado diretamente o shell pelo usuário.
#
# Ele serve para no caso de uma instalação inicial no momento do build do docker
# ele instalar os componentes e criar a chave do Laravel, e migrar e alimentar
# novas, ou atualizações da estrutura do banco de dados.
#---------------------------------------------------

#--
# Display Help
#------
Help()
{
   echo "Prepara a aplicação para execução inicial ou atualização."
   echo
   echo "Syntax: update [-h||i|r|u] [--seed]"
   echo "opções:"
   echo "-h      Exibe este help."
   echo "-i      Instalação inicial: Gera a chave de segurança e migra a estrutura da base de dados."
   echo "-r      Rebuild: Apaga toda a base de dados e executa novamente toda migrações existentes."
   echo "-u      Update: Opção padrão roda o migrate para verificar se existe algo nova na estrutura de dados a implementar."
   echo "--seed  Alimenta a base de dados com dados falsos para testes. NÃO UTILIZE ESSA OPÇÃO EM PRODUÇÃO."
   echo
}

#--
# Steps: executa os passos de acordo com as opções passadas
#
Steps()
{
    # Verificando a conexão com o banco de dados
    until mysql -h $MYSQL_HOST -u $MYSQL_USER --password=$MYSQL_PASSWORD $MYSQL_DATABASE -e status > /dev/null
    do
        echo "Aguardando o servidor do banco de dados estar pronto."
        sleep 10
    done


    # instala ou atualiza o composer
    composer install

    if [ $1 == "i" ]; then
        echo "Executa os procedimentos pós instalação."

        php artisan key:generate
        php artisan migrate $2

    elif  [ $1 == "r" ]; then
        echo "Refaz toda a estrutura de dados."

        php artisan migrate:fresh $2
    else
        echo "Verifica atualizações."
        php artisan migrate
    fi

    # Limpando o cache
    php artisan cache:clear
}


# Pega o argumento passado para o script
# -l argumentos com texto longo. Ex: --seed
# -o argumentos com uma única letra. Ex: -h
options=$(getopt -o "hiru" -l "seed" -- "$@")

eval set -- "$options"

while true; do
   case $1 in
        -i) # Install
            Steps i $2
            exit;;

        -r) # Rebuild
            Steps r $2
            exit;;

        -u) #update
            Steps
            exit;;

        -h | *) # display Help
            Help
            exit;;
   esac
   shift
done

exit 0