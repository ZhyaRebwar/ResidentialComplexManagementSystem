import subprocess

def docker_compose_up():
    command = ["docker-compose", "stop"]
    subprocess.Popen(command, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

if __name__ == "__main__":
    docker_compose_up()
