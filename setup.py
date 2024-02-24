import os
import subprocess

# check if Composer is installed
def is_composer_installed():
    try:
        subprocess.run(['composer', '--version'])
        return True
    except FileNotFoundError:
        return False

def is_docker_installed():
    try:
        subprocess.run(['docker', '--version'])
        return True
    except FileNotFoundError:
        return False

# install Composer 
def install_composer():
    subprocess.run(['pip', 'install', 'composer'])

def set_up_docker_image():
    command = "docker build -t myproject_mysql -f Dockerfile.mysql ."

    try:
        subprocess.run(command, shell=True, check=True)
        print("Docker build completed successfully.")
    except subprocess.CalledProcessError as e:
        print("Error while executing Docker build command:", e)


# Check if Laravel is installed
def check_laravel():
    if not os.path.exists("artisan"):
        print("Laravel is not installed. Please install Laravel before proceeding.")
    else:
        print("Laravel is already installed.")

if __name__ == "__main__":
    if is_composer_installed():
        print("Composer is already installed.")
    else:
        print("Composer is not installed.")
        print("Installing Composer.")
        install_composer()

    if is_docker_installed():
        print("Docker is already installed.")
    else:
        print("Docker is not installed.")
        print("Please install docker.")

    set_up_docker_image()

    check_laravel()
