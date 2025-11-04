@php
	$compact = $compact ?? false;
@endphp

<div class="halpha-overflow-x-auto halpha-rounded-xl halpha-border halpha-border-gray-700 halpha-bg-[#050506]">
	<table class="halpha-w-full halpha-min-w-[900px]">
		<thead>
			<tr class="halpha-text-left">
				<th class="halpha-px-6 halpha-py-4 halpha-text-gray-200 halpha-text-base md:halpha-text-lg">Rank</th>
				<th class="halpha-px-6 halpha-py-4 halpha-text-gray-200 halpha-text-base md:halpha-text-lg">Team Volume (USD)</th>
				<th class="halpha-px-6 halpha-py-4 halpha-text-gray-200 halpha-text-base md:halpha-text-lg">Personal Deposit</th>
				<th class="halpha-px-6 halpha-py-4 halpha-text-gray-200 halpha-text-base md:halpha-text-lg">Direct Referrals</th>
				<th class="halpha-px-6 halpha-py-4 halpha-text-gray-200 halpha-text-base md:halpha-text-lg">Cash Bonus</th>
			</tr>
		</thead>
		<tbody class="halpha-text-gray-300 halpha-text-sm">
			@foreach($ranks as $r)
				<tr class="halpha-border-t halpha-border-gray-800">
					<td class="halpha-px-6 halpha-py-4">{{ $r['rank'] }}</td>
					<td class="halpha-px-6 halpha-py-4">{{ $r['team_volume'] }}</td>
					<td class="halpha-px-6 halpha-py-4">{{ $r['personal_deposit'] }}</td>
					<td class="halpha-px-6 halpha-py-4">{{ $r['direct_referrals'] }}</td>
					<td class="halpha-px-6 halpha-py-4">{{ $r['cash_bonus'] }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

@if(!$compact)
	<p class="halpha-mt-3 halpha-text-xs halpha-text-gray-400">Volume does not reset monthly — it promotes long-term growth.
	</p>
@endif