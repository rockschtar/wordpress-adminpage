<?php

namespace Rockschtar\WordPress\AdminPage\Views;

use Rockschtar\WordPress\AdminPage\Models\ListTableColumn;
use Rockschtar\WordPress\AdminPage\Models\ListTableColumns;
use Rockschtar\WordPress\AdminPage\Models\ListTablePagination;
use WP_Screen;

abstract class AdminPageListTable implements AdminPageViewInterface
{

    /**
     * @var array
     */
    private $items;
    /**
     * @var string
     */
    private $id;
    /**
     * @var WP_Screen
     */
    private $screen;
    private $content_before;
    private $content_after;
    private $table_nav_extra;
    private $current_page;

    public function __construct(string $id, array $items = array())
    {
        $this->id = sanitize_key($id);
        $this->items = $items;
        $this->screen = convert_to_screen($this->id);
    }

    final public function setCurrentPage(int $current_page): void
    {
        $this->current_page = $current_page;
    }

    /**
     * @param mixed $content_before
     */
    final public function setContentBefore($content_before): void
    {
        $this->content_before = $content_before;
    }

    /**
     * @param mixed $content_after
     */
    final public function setContentAfter($content_after): void
    {
        $this->content_after = $content_after;
    }

    final public function displayView(): void
    {
        echo $this->getTableHtml();
    }

    final public function getTableHtml(): string
    {
        $table_html = $this->getContentBefore();
        $table_html .= $this->getTableNav('top');
        $table_html .= "<table class=\"widefat\">\n";

        $table_html .= $this->getTableHeader();

        $table_html .= $this->getTableRows();
        $table_html .= '</table>';
        $table_html .= $this->getTableNav('bottom');
        $table_html .= $this->getContentAfter();
        return $table_html;
    }

    /**
     * @return mixed
     */
    private function getContentBefore()
    {
        $content_before = apply_filters('wpu_listtable_before_table', $this->content_before, $this->screen->id);
        $content_before = apply_filters('wpu_listtable_before_table_' . $this->screen->id, $content_before);

        return $content_before;
    }

    private function getTableNav($which)
    {
        $html = apply_filters('wpu_listtable_before_tablenav', '');
        $html .= '<div class="tablenav ' . esc_attr($which) . '">';
        $html .= '<div class="alignleft actions bulkactions"></div>'; //TODO Implement Bulk Actions
        $html .= $this->getTableNavExtra();
        $html .= $this->getPaginationHTML($which);
        $html .= '<br class="clear" />';
        $html .= '</div>';
        $html .= apply_filters('wpu_listtable_after_tablenav', '');
        return $html;
    }

    final public function getTableNavExtra(): ?string
    {
        return $this->table_nav_extra;
    }

    final public function setTableNavExtra(string $table_nav_extra): void
    {
        $this->table_nav_extra = $table_nav_extra;
    }

    private function getPaginationHTML($which)
    {
        $pagination = $this->getPagination();

        if (null === $pagination) {
            return null;
        }

        if (!$pagination->isValid()) {
            return '';
        }

        $total_items = $pagination->getTotalItems();
        $total_pages = $pagination->getTotalPages();

        $output = '<span class="displaying-num">' . sprintf(_n('%s item', '%s items', $total_items), number_format_i18n($total_items)) . '</span>';

        $current_page = $this->getCurrentPage();
        $removable_query_args = wp_removable_query_args();

        $current_url = set_url_scheme('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

        $current_url = remove_query_arg($removable_query_args, $current_url);

        $page_links = array();

        $total_pages_before = '<span class="paging-input">';
        $total_pages_after = '</span></span>';

        $disable_first = $disable_prev = $disable_next = $disable_last = false;

        if ($current_page === 1) {
            $disable_first = true;
            $disable_prev = true;
        }

        if ($current_page === 2) {
            $disable_first = true;
        }

        if ($current_page === $total_pages) {
            $disable_last = true;
            $disable_next = true;
        }

        if ($current_page === $total_pages - 1) {
            $disable_last = true;
        }


        if ($disable_first) {
            $page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&laquo;</span>';
        } else {
            $page_links[] =
                sprintf("<a class='first-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>", esc_url(remove_query_arg('paged', $current_url)), __('First page'), '&laquo;');
        }

        if ($disable_prev) {
            $page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&lsaquo;</span>';
        } else {
            $page_links[] =
                sprintf("<a class='prev-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>", esc_url(add_query_arg('paged', max(1, $current_page - 1), $current_url)), __('Previous page'), '&lsaquo;');
        }

        if ('bottom' === $which) {
            $html_current_page = $current_page;
            $total_pages_before =
                '<span class="screen-reader-text">' . __('Current Page') . '</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">';
        } else {
            $html_current_page =
                sprintf("%s<input class='current-page' id='current-page-selector' type='text' name='paged' value='%s' size='%d' aria-describedby='table-paging' /><span class='tablenav-paging-text'>", '<label for="current-page-selector" class="screen-reader-text">' . __('Current Page') . '</label>', $current_page, strlen($total_pages));
        }
        $html_total_pages = sprintf("<span class='total-pages'>%s</span>", number_format_i18n($total_pages));
        $page_links[] = $total_pages_before . sprintf(_x('%1$s of %2$s', 'paging'), $html_current_page, $html_total_pages) . $total_pages_after;

        if ($disable_next) {
            $page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&rsaquo;</span>';
        } else {
            $page_links[] =
                sprintf("<a class='next-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>", esc_url(add_query_arg('paged', min($total_pages, $current_page + 1), $current_url)), __('Next page'), '&rsaquo;');
        }

        if ($disable_last) {
            $page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&raquo;</span>';
        } else {
            $page_links[] =
                sprintf("<a class='last-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>", esc_url(add_query_arg('paged', $total_pages, $current_url)), __('Last page'), '&raquo;');
        }

        $pagination_links_class = 'pagination-links';
        $infinite_scroll = false;
        if (!empty($infinite_scroll)) {
            $pagination_links_class = ' hide-if-js';
        }
        $output .= "\n<span class='$pagination_links_class'>" . implode("\n", $page_links) . '</span>';

        $page_class = ' no-pages';

        if ($total_pages) {
            $page_class = $total_pages < 2 ? ' one-page' : '';
        }

        return "<div class='tablenav-pages{$page_class}'>$output</div>";
    }

    abstract protected function getPagination(): ?ListTablePagination;

    private function getCurrentPage(): int
    {

        $pagenum = $this->current_page;
        $pagenum = $pagenum ?? isset($_REQUEST['paged']) ? absint($_REQUEST['paged']) : 1;

        $p = $this->getPagination();

        if ($p === null) {
            return 1;
        }

        if ($pagenum > $p->getTotalPages()) {
            $pagenum = $p->getTotalPages();
        }

        return max(1, $pagenum);
    }

    private function getTableHeader(): string
    {
        $columns = $this->getColumns();

        $html = do_action('wpu_listtable_before_table_header', $this->screen->id);
        $html .= '<thead>';
        foreach ($columns->getColumns() as $column) {
            $html .= '<td class="row-title">' . $column->getTitle() . '</td>';
        }
        $html .= '</thead>';
        $html .= do_action('wpu_listtable_after_table_header', $this->screen->id);
        return $html;
    }

    abstract public function getColumns(): ListTableColumns;

    private function getTableRows(): string
    {
        $html = '<tbody>';
        foreach ($this->items as $index => $item) {
            $row_number = $index + 1;
            $html .= $this->getTableRow($item, $row_number);
        }
        $html .= '</tbody>';

        return $html;
    }

    private function getTableRow($item, int $row_number): string
    {
        $columns = $this->getColumns();

        $css_class = ($row_number % 2 === 0) ? '' : 'alternate';

        $html = apply_filters('wpu_listtable_before_table_row_' . $row_number, '', $this->screen->id);
        $html .= '<tr class="' . $css_class . '">';
        foreach ($columns->getColumns() as $column) {
            $html .= '<td>' . $this->getColumnItemValue($column, $item) . '</td>';
        }
        $html .= '</tr>';
        $html .= apply_filters('wpu_listtable_after_table_row_' . $row_number, '', $this->screen->id);

        return $html;
    }

    abstract protected function getColumnItemValue(ListTableColumn $column, $item): ?string;

    /**
     * @return mixed
     */
    private function getContentAfter()
    {
        $content_after = apply_filters('wpu_listtable_before_table', $this->content_after, $this->screen->id);
        $content_after = apply_filters('wpu_listtable_before_table_' . $this->screen->id, $content_after);
        return $content_after;
    }

    final protected function getScreen(): WP_Screen
    {
        return $this->screen;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
