ssh-keygen
cat ~/.ssh/id_rsa
cat ~/.ssh/id_rsa.pub >> ~/.ssh/authorized_keys
ssh-keyscan rsa -t 52.14.18.78
