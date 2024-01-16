function handleDragOver(event) {
	event.preventDefault();
	event.dataTransfer.dropEffect = "copy";
	let dragText = document.getElementById("drag-text");
	dragText.textContent = "Soltar a imagem";
}
function handleDragLeave(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = "copy";
	let dragText = document.getElementById("drag-text");
	dragText.textContent = "Arraste e solte uma imagem";
}
function handleDrop(event) {
	event.preventDefault();

	let dragText = document.getElementById("drag-text");
	dragText.textContent = "Envie a imagem";

	const files = event.dataTransfer.files;
	
	if (files.length >= 1) {
		handleFiles(files);
	}
}
function handleFiles(files) {
    for (const file of files) {
		const newFileList = new DataTransfer();
		newFileList.items.add(file);
        createImage(newFileList);

	}
}
