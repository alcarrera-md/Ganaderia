import ollama

response = ollama.generate(model='llama3', prompt='¿Qué es la ganadería?')
print(response['response'])