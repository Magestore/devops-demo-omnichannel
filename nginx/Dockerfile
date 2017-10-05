FROM nginx

RUN apt-get update
RUN apt-get upgrade -y

# open for ssh client to connect this server
RUN apt-get install -y openssh-server
RUN mkdir /var/run/sshd
RUN echo 'root:magestoreomni123@' | chpasswd
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed -i 's@\#PermitRootLogin@PermitRootLogin@' /etc/ssh/sshd_config
# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd
ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile
# SSH Authorization for python_api container
RUN mkdir -p /root/.ssh
RUN echo "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDMMp+x3Rt5CP9Ongx2Nqej28qtv5z18SgtB823TsvViRYAhwJ6rLUZrYASyc33vAeOu+HdXrFG8o91uPqJJ+He7vI1kR73qEFIkkBnrMCQnkTxv61uYeG8Rz/jFSYLrPAgsUScELLap0wX65/mHcHzhuljU6hItWCqbpXHed1da4poU5mPSkwPSZ7i+RZ8TZbCe0ynJQsU4yOP9QzDhRYJUswNwlBa8t9m40LkOzcdLEAjTj2phQfJoe2NKIpL1nTc1rcCymc3xTX8gepovV4HRxHqE6UmOpUlkHAW01RwZiyMJypX5CWKl90WMy/OYLd7BO2AXYc4KIazMAPAzBf1 root@api" >> /root/.ssh/authorized_keys


COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

VOLUME /etc/enginx/conf.d

RUN /etc/init.d/ssh start

CMD ["nginx", "-g", "daemon off;"]
