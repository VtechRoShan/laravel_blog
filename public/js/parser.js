function json_to_html(edjs_data, element = "blog-detail-content") {
    const config = {
        image: {
            use: "figure",
            imgClass: "img",
            figureClass: "fig-img text-center mt-3 mb-4",
            figCapClass: "fig-cap mt-2",
            path: "absolute",
        },
        header: {
            hClass: "my-4",
        },
        paragraph: {
            pClass: "paragraph my-4",
        },
        code: {
            codeBlockClass: "code-block",
        },
        embed: {
            useProvidedLength: false,
        },
        quote: {
            applyAlignment: false,
        },
    };
    const parser = new edjsParser(config);

    const rawData = JSON.parse(edjs_data);

    if (rawData) {
        const markup = parser.parse(rawData);
        displayHTML(markup);
    }

    function displayHTML(markup) {
        const outputDiv = document.getElementById(element);
        outputDiv.innerHTML = "";
        outputDiv.innerHTML = markup;
    }
}
