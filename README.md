# UQBITZ Hub de Integração Imobiliária

Plugin WordPress que integra seus imóveis com os principais portais imobiliários do Brasil (ImovelWeb, Wimoveis, Casa Mineira) via feed XML no formato OpenNavent.

## Portais suportados

- [ImovelWeb](https://www.imovelweb.com.br)
- [Wimoveis](https://www.wimoveis.com.br)
- [Casa Mineira](https://www.casamineira.com.br)

## Requisitos

- WordPress 6.0+
- PHP 8.0+
- [Advanced Custom Fields](https://www.advancedcustomfields.com/)

## Instalação

### Via WordPress.org (em breve)

1. No painel do WordPress, acesse **Plugins → Adicionar Novo**
2. Pesquise por **"UQBITZ Hub"**
3. Clique em **Instalar** e depois **Ativar**

### Via GitHub (download direto)

1. Baixe a última release: [Download v3.1.0](https://github.com/feperrella/uqbitz-hub-imoveis/releases/latest)
2. No painel do WordPress, acesse **Plugins → Adicionar Novo → Enviar plugin**
3. Selecione o arquivo `.zip` baixado e clique em **Instalar agora**
4. Ative o plugin

### Manual

1. Baixe e extraia a [última release](https://github.com/feperrella/uqbitz-hub-imoveis/releases/latest)
2. Copie a pasta para `/wp-content/plugins/uqbitz-hub-imoveis/`
3. Ative o plugin no painel do WordPress

## Configuração

1. Acesse **Hub Imóveis → Configurações** no menu do WordPress
2. Preencha o **Código da Imobiliária** (fornecido pelo portal)
3. Preencha os dados de contato (e-mail, nome, telefone)
4. Cadastre imóveis preenchendo todos os campos obrigatórios
5. Acesse **Hub Imóveis → Visão Geral** para verificar o status do feed

### Integração com o portal

1. Copie a URL do feed exibida em **Hub Imóveis → Visão Geral**
2. No painel do portal (ex: ImovelWeb), vá em **Integração de Anúncios → XML**
3. Cole a URL do feed e salve

## Feed XML

O feed é gerado automaticamente em:

```
https://seusite.com.br/wp-json/portalimoveis/v1/feed
```

## Estrutura do repositório

```
├── assets/          # Screenshots, ícone e banner
├── tags/3.1.0/      # Release estável (pronto para instalar)
└── trunk/           # Código de desenvolvimento
```

## Licença

GPLv2 ou posterior. Veja [LICENSE](trunk/LICENSE).

## Autor

**Fernando Perrella** ([UQBITZ](https://uqbitz.com))
