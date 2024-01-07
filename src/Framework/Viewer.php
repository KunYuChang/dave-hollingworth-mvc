<?php

namespace Framework;

class Viewer
{
	public function render(string $template, array $data = []): string
	{
		extract($data, EXTR_SKIP);

		// 使用輸出緩衝載入模板的內容
		ob_start();
		require "views/$template";
		return ob_get_clean();
	}
}
