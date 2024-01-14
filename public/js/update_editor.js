function update_editor(rawData, csrfToken) {
    // Editor Configuration
    const ImageTool = window.ImageTool;
    const baseUrl = window.location.origin;
    class Image extends ImageTool {
        removed() {
            if (this.data.file?.url) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    type: "DELETE",
                    url: baseUrl + "/delete-image",
                    data: {
                        file_url: this.data.file.url,
                    },
                    success: function (data) {
                        if (data.success === 1) {
                            // Create a click event
                            const clickEvent = new Event("click");
                            // Trigger the click event on the updateBlogBtn element
                            updateBlogBtn.dispatchEvent(clickEvent);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request failed:", error);
                        alert("Something went wrong");
                    },
                });
            }
        }
    }

    const editor = new EditorJS({
        holder: "editorjs",
        tools: {
            header: {
                class: Header,
                inlineToolbar: ["marker", "link"],
                config: {
                    placeholder: "Header",
                },
                shortcut: "CMD+SHIFT+H",
            },
            paragraph: {
                class: Paragraph,
                inlineToolbar: true,
            },
            raw: RawTool,
            image: {
                class: Image,
                config: {
                    additionalRequestHeaders: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    endpoints: {
                        byFile: `${baseUrl}/upload-image`,
                        byUrl: `${baseUrl}/upload-image/url`,
                    },
                },
            },
            list: {
                class: List,
                inlineToolbar: true,
                shortcut: "CMD+SHIFT+L",
            },
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                config: {
                    quotePlaceholder: "Enter a quote",
                    captionPlaceholder: "Quote's author",
                },
                shortcut: "CMD+SHIFT+O",
            },
            warning: Warning,
            marker: {
                class: Marker,
                shortcut: "CMD+SHIFT+M",
            },
            code: {
                class: CodeTool,
                shortcut: "CMD+SHIFT+C",
            },
            delimiter: Delimiter,
            inlineCode: {
                class: InlineCode,
                shortcut: "CMD+SHIFT+C",
            },
            linkTool: LinkTool,
            embed: Embed,
            table: {
                class: Table,
                inlineToolbar: true,
                shortcut: "CMD+ALT+T",
            },
        },
        data: rawData,
        onReady: () => {
            new Undo({
                editor,
            });
        },
    });
    editor.isReady
        .then(() => {
            console.log("Editor.js is ready to go!");
        })
        .catch((reason) => {
            console.log(`Editor.js initialization failed because of ${reason}`);
        });
    return editor;
}
