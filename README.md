# TCCBlockchain
Trabalho desenvolvido como requisito para aprovação na disciplina de TCC, do curso Tecnologia em Análise e Desenvolvimento de Sistemas. Baseado no projeto: https://github.com/dvf/blockchain.

Requisitos: 
1) Python 3.6+ e pipenv. Instalação do pipenv e depen requerimentos.
$ pip install pipenv 
$ pipenv install 
2) Servidor MySQL
3) Servidor Apache (utilizamos o servidor de desenvolvimento do próprio Laravel)

Pode-se executar a blockchain deve-se utilizando os comandos abaixo dentro da pasta blockchaon. Por padrão a porta utilizada é a 5000. Pode-se utilizar o parâmetro -p para decidir outra porta. Exemplo
$ pipenv run python blockchain.py
$ pipenv run python blockchain.py -p 5001
