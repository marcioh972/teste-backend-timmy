# Teste backend Timmy: receitas de Bolos

Plugin WordPress para cadastro e exibição de receitas de bolos.

## Requisitos
- WordPress 5.8+ e PHP 7.4+
- Campos criados com meta boxes nativas, sem ACF.

## Instalação
1. Compacte/baixe a pasta `receitas-de-bolos` (ou use o `.zip`).
2. No admin: **Plugins -> Adicionar novo -> Enviar plugin**, selecione o `.zip` e clique em **Instalar agora**.
   (Alternativa: copie a pasta para `wp-content/plugins/`.)
3. Clique em **Ativar**.
4. Se o link das receitas retornar 404: **Configurações -> Links permanentes -> Salvar alterações**.

## Uso
- Menu **Receitas de Bolos -> Adicionar nova**:
  - **Título**: título da receita
  - **Editor**: descrição
  - **Detalhes da receita**: tempo de preparo (minutos) e ingredientes (um por linha)
  - **Imagem da receita**: imagem destacada
- Archive: `/receitas-de-bolos/` ;  imagem, título e tempo de preparo (9 por página, com paginação).
- Single: dados da receita + seção **Veja mais** com 3 sugestões (imagem e título), abaixo dos detalhes.



## Personalização
O tema pode sobrescrever os templates criando `archive-receita_bolo.php` / `single-receita_bolo.php` na raiz do tema.
Funciona com temas clássicos e de blocos.
