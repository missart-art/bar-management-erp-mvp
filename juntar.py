import os

# Extensões que você quer copiar
extensions = ['.html', '.css', '.js', '.php', '.json', '.toml']

# --- AQUI ESTÁ A MUDANÇA ---
# Adicionei as pastas da sua imagem nesta lista para serem ignoradas
ignore = [
    'node_modules', 
    '.git', 
    '.netlify', 
    'vendor', 
    'jquery-main',  # <-- Pasta ignorada
    'pico-1.5.9'    # <-- Pasta ignorada
]

output = 'projeto_completo.txt'

def merge_files():
    count = 0
    with open(output, 'w', encoding='utf-8') as outfile:
        for root, dirs, files in os.walk("."):
            # Esta linha mágica remove as pastas da lista 'ignore' da busca
            dirs[:] = [d for d in dirs if d not in ignore]
            
            for file in files:
                if file.endswith(tuple(extensions)) and file != output and file != "juntar.py":
                    path = os.path.join(root, file)
                    
                    # Escreve o cabeçalho e o conteúdo
                    outfile.write(f"\n\n{'='*40}\n")
                    outfile.write(f"ARQUIVO: {path}\n")
                    outfile.write(f"{'='*40}\n\n")
                    
                    try:
                        with open(path, 'r', encoding='utf-8', errors='ignore') as infile:
                            outfile.write(infile.read())
                            count += 1
                    except Exception as e:
                        print(f"Erro ao ler {file}: {e}")

    print(f"Sucesso! {count} arquivos foram copiados (ignorando as pastas indesejadas).")

if __name__ == "__main__":
    merge_files()