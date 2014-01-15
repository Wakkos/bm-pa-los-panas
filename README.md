# Cómo contribuir en bm-pa-los-panas

Por favor, tómate un momento en revisar la siguiente documentación par a mantener el proceso de contribuciones fácil y efectivo para todos los implicados.

Siguiendo estas pequeñas directrices nos ayuda a respetar el tiempo de todos los desarrolladores y diseñadores que colaboran en este proyecto “open source”.


## Usando el Issue Tracker de Github

En Issue Tracker es donde debemos enviar nuestros [reportes de fallos](#reporte-de-fallos), [peticiónes de características ](#características) y [pull requests](#pull-requests), pero por favor, respeta las siguientes restricciones:

* Por favor **no** uses el issue tracker para peticiones personales de ayuda.

* Por favor **no** trolees o denigres ninguna cuestión. Mantén la discusión dentro del tema y respeta las opiniones de otros.

<a name="bugs"></a>
## Reporte de fallos

Un fallo debe ser _demostrable_ y causado por el código en el repositorio. Los buenos reportes de fallos/bugs son de mucha ayuda - gracias!

Reportando bugs:

1. **Usa la búsqueda de fallos (issues) de GitHub** - Revisa si el fallo ya ha sido reportado.

2. **Revisa si el fallo ya ha sido arreglado** - Intenta reproducirlo con la rama “master” más actualizada del repositorio.

3. **Aísla el problema** - Crea un ejemplo en vivo (P.ej. en [Codepen](http://codepen.io)) de un [testeo reducido](http://css-tricks.com/reduced-test-cases/).

Un buen reporte de un problema/bug no debería dejar al resto persiguiéndote para más información. por favor, se lo más detallado posible en tu reporte. ¿Cuál es tu ambiente de desarrollo? ¿Qué pasos reproducirán el error? ¿Qué navegador(es) y OS presentan el problema? ¿Qué esperas que se muestre? Todos estos detalles ayudarán al equipo a resolver problemas y fallos.

Ejemplo:

> Título corto y descriptivo de un error
>
> Un resumen del error y del ambiente donde ocurre (OS, Navegador, etc…). Si
  > procede, incluye los pasos para resolver el error.
>
> 1. Este es el primer paso
> 2.  Este es el segundo paso
> 3. Más pasos, etc...
>
> `<url>` - El link para el entorno de testeo reducido
>
> Cualquier otra información que quieras compartir que sea relevante
> para resolver el error reportado. Pueden ser líneas de código que hayas
  > identificado, soluciones u opiniones.


<a name="features"></a>
## Petición de características

Las peticiones de características son bienvenidas. Pero tómate un momento para analizar si encaja en los objetivos del proyecto.  *Depende de ti* convencer al equipo de la necesidad de esa característica. Por favor, provee tantos detalles como sean posibles.

<a name="pull-requests"></a>
## Pull requests

Pull request de mejoras, nuevas características y “reparaciones” son una gran ayuda. Deben enfocarse siempre en los objetivos del proyecto y evitar commits innecesarios.

**Por favor, pregunta** antes de embarcarte en una tarea , o corres el riesgo de perder tiempo en algo que el equipo pueda no querer implementar o fusionar en el proyecto.

Es importante que te adhieras a las convenciones de código usadas en el proyecto (espacios en blanco, comentarios bien explicados) y otros requerimientos (como tests previos).

Sigue este proceso si quieres que tu trabajo sea considerado para incluirlo en el proyecto:

1. Haz un [Fork](http://help.github.com/fork-a-repo/) al proyecto, clona tu fork y configura el remoto:
```bash
 # Clona tu fork del repositorio en el directorio actual
git clone https://github.com/<your-username>/bm-pa-los-panas
 # Navega al nuevo directorio clonado
cd bm-pa-los-panas
 # Asigna el repositorio original a un remoto llamado “upstream”
git remote add upstream https://github.com/Wakkos/bm-pa-los-panas
```

2. Si clonaste hace tiempo ya, obtén los últimos cambios desde upstream:

```bash
   git checkout master
   git pull upstream master
   ```

3. Nunca trabajes directamente en `master`. Crea una nueva rama (a partir de `master`) que contenga la característica, cambio o arreglo en el que estás trabajando:

   ```bash
   git checkout -b <topic-branch-name>
   ```

4. Haz commit a tus cambios en trozos lógicos de código. Por favor, sigue estas [convenciones de mensajes de Git](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html) o tu código puede que no se fusione en el proyecto principal.  Usa la característica [_interactive rebase_](https://help.github.com/articles/interactive-rebase) de Git para ajustar tus commits antes de hacerlos públicos.

5. Locally rebase the upstream development branch into your topic branch:

   ```bash
   git pull --rebase upstream master
   ```

6. Haz Push de tu rama en tu fork:

   ```bash
   git push origin <nombre-rama>
   ```

10. [Abre una petición de pull](https://help.github.com/articles/using-pull-requests/)
    con una título claro y descripción.

**IMPORTANTE**: Al enviar un commit, acuerdas con las licencias usadas en el proyecto y que tu alma es nuestra sin que compremos una compañía que hace termostatos.

<a name="maintainers"></a>