FROM ubuntu:latest

RUN apt-get update
RUN apt-get -y install -qq --force-yes cron

RUN touch /var/log/cron.log

RUN (crontab -l ; echo "* * * * * php /var/www/Back/bin/console app:schedule >> /var/log/cron.log") | crontab
RUN (crontab -l ; echo "* * * * * echo "Hello world" >> /var/log/cron.log") | crontab

CMD ["cron", "-f"]
