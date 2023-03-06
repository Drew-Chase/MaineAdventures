
/**
 * It opens a new window, writes the HTML to it, and then prints it.
 */
async function Print(id) {
    let print_window = window.open(`/assets/php/itemized.php?id=${id}`, "PRINT", 'width=1280,height=720')
    print_window.document.close();
    print_window.onload = () => {
        print_window.focus();
        print_window.print();
        print_window.close();
    }
}