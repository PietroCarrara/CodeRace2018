FROM greyltc/lamp

RUN sed -i '/AllowOverride None/s/None/All/g' /etc/httpd/conf/httpd.conf
RUN sed -i '/AllowOverride None/s/none/All/g' /etc/httpd/conf/httpd.conf

# Banco
ADD config-mysql.sh /usr/sbin/config-mysql.sh
# ENTRYPOINT config-mysql.sh
CMD start-servers; setup-mysql-user; config-mysql.sh; sleep infinity; 

