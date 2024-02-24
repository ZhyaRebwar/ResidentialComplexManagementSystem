import subprocess

def docker_compose_up():
        command = ["docker-compose", "-f", "docker-compose.yml", "up"]
        subprocess.Popen(command, stdout=subprocess.PIPE, stderr=subprocess.PIPE)  

def laravel_start():
    try:
        subprocess.run(['php', 'artisan', 'serve'], check=True)
    except subprocess.CalledProcessError as e:
        print("Error while starting Laravel server:", e)
    except KeyboardInterrupt:
        print("The project stopped.")

if __name__ == "__main__":
    docker_compose_up()
    laravel_start()
