import subprocess

def database_setup():
        subprocess.run(['php', 'artisan', 'migrate'], check=True)
        subprocess.run(['php', 'artisan', 'db:seed'], check=True)

if __name__ == "__main__":
    database_setup()
