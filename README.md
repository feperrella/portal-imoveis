# Portal Imóveis – Feed XML (OpenNavent)

Plugin WordPress que gera automaticamente um feed XML no formato OpenNavent para sincronizar imóveis com portais imobiliários brasileiros.

## Portais suportados

- [ImovelWeb](https://www.imovelweb.com.br)
- [Wimoveis](https://www.wimoveis.com.br)
- [Casa Mineira](https://www.casamineira.com.br)

## Requisitos

- WordPress 6.0+
- PHP 8.0+
- [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/)

## Instalação

1. Clone ou baixe este repositório
2. Copie a pasta `trunk/` para `/wp-content/plugins/portal-imoveis/`
3. Ative o plugin no painel do WordPress
4. Acesse **Portal Imóveis → Configurações** e preencha os dados

## Estrutura (WordPress.org SVN)

```
├── assets/          # Screenshots, ícone e banner do plugin
│   ├── banner-1544x500.png
│   ├── banner-772x250.png
│   ├── icon-128x128.png
│   ├── icon-256x256.png
│   └── screenshot-1.png
├── tags/            # Releases versionadas
│   └── 3.1.0/
├── trunk/           # Código de desenvolvimento atual
│   ├── portal-imoveis.php
│   ├── readme.txt
│   ├── uninstall.php
│   ├── CHANGELOG.md
│   └── LICENSE
└── README.md        # Este arquivo (GitHub)
```

## Feed XML

O feed é gerado automaticamente em:

```
https://seusite.com.br/wp-json/portalimoveis/v1/feed
```

## Deploy para WordPress.org SVN

```bash
# Checkout do SVN
svn co https://plugins.svn.wordpress.org/portal-imoveis/ svn-portal-imoveis

# Copiar arquivos do trunk
cp trunk/* svn-portal-imoveis/trunk/

# Criar tag
svn cp svn-portal-imoveis/trunk svn-portal-imoveis/tags/3.1.0

# Commit
cd svn-portal-imoveis
svn ci -m "Release 3.1.0" --username feperrella
```

## Licença

GPLv2 ou posterior. Veja [LICENSE](trunk/LICENSE).

## Autor

**Fernando Perrella** ([UQBITZ](https://uqbitz.com))
