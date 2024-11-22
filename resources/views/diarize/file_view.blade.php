<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrollable PDF Viewer</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <style>
        #preview {
            width: 100%; /* Full width */
            height: 600px; /* Define the height for the scrollable container */
            overflow-y: auto; /* Enable vertical scrolling */
            border: 1px solid #ccc; /* Optional: Add a border for clarity */
            padding: 10px; /* Add padding for spacing */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
        }

        .pdf-page {
            margin: 10px auto; /* Center the canvas */
            border: 1px solid #ddd; /* Optional: Add a light border */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
            display: block; /* Ensure proper alignment */
            max-width: 90%; /* Restrict the maximum width of the canvas */
        }
    </style>
</head>
<body>
    <h1>Select a PDF File</h1>
    <input type="file" id="fileInput" accept="application/pdf">
    <div id="preview">
        <p>No file selected yet.</p>
    </div>

    <script>
        document.getElementById('fileInput').addEventListener('change', function (event) {
    const file = event.target.files[0]; // Get the selected file
    const preview = document.getElementById('preview');
    preview.innerHTML = ''; // Clear previous content

    if (file) {
        if (file.type === 'application/pdf') {
            const fileReader = new FileReader();

            fileReader.onload = function (e) {
                const typedArray = new Uint8Array(e.target.result);

                // Load the PDF document
                pdfjsLib.getDocument(typedArray).promise.then(function (pdf) {
                    const totalPages = pdf.numPages;

                    // Render each page inside the preview container
                    for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
                        renderPage(pdf, pageNum, preview);
                    }
                }).catch(function (error) {
                    console.error('Error loading PDF:', error);
                    preview.innerHTML = '<p>Error loading PDF file.</p>';
                });
            };

            fileReader.readAsArrayBuffer(file); // Read the file as an ArrayBuffer
        } else {
            preview.innerHTML = '<p>Please select a valid PDF file.</p>';
        }
    } else {
        preview.innerHTML = '<p>No file selected.</p>';
    }
});

function renderPage(pdf, pageNumber, container) {
    pdf.getPage(pageNumber).then(function (page) {
        const scale = 0.75; // Adjust the scale to reduce size
        const viewport = page.getViewport({ scale: scale });

        // Create a canvas for the page
        const canvas = document.createElement('canvas');
        canvas.classList.add('pdf-page');
        const ctx = canvas.getContext('2d');

        // Set canvas dimensions
        canvas.width = viewport.width;
        canvas.height = viewport.height;

        // Append canvas to the container
        container.appendChild(canvas);

        // Render the page on the canvas
        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
        page.render(renderContext);
    }).catch(function (error) {
        console.error(`Error rendering page ${pageNumber}:`, error);
    });
}

    </script>
</body>
</html>
